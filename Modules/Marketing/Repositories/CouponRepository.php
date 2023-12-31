<?php
namespace Modules\Marketing\Repositories;

use Carbon\Carbon;
use Modules\Marketing\Entities\Coupon;
use Modules\Marketing\Entities\CouponProduct;
use Modules\Marketing\Entities\CouponBrand;
use Modules\Seller\Entities\SellerProduct;

class CouponRepository {

    public function getAll(){
        $user = auth()->user();
        if($user->role->type == 'superadmin' || $user->role->type == 'admin' || $user->role->type == 'staff'){
            return Coupon::with('coupon_uses');
        }
        elseif($user->role->type == 'seller'){
            return Coupon::with('coupon_uses')->where('created_by',$user->id);
        }else{
            return [];
        }
    }
    public function getProduct(){

        $user = auth()->user();
        if($user->role->type == 'superadmin' || $user->role->type == 'admin' || $user->role->type == 'staff'){
            return SellerProduct::with('product', 'seller.role')->activeSeller()->get();
        }
        elseif($user->role->type == 'seller'){
            return SellerProduct::where('user_id',$user->id)->activeSeller()->get();
        }else{
            return [];
        }
    }

    public function store($data){
        if($data['coupon_type'] == 3){
            $data['discount'] = 20;
        }

        $coupon = Coupon::create([
            'title' => $data['coupon_title'],
            'coupon_code' => $data['coupon_code'],
            'coupon_type' => $data['coupon_type'],
            'start_date' => Carbon::parse($data['start_date'])->format('Y-m-d'),
            'end_date' => Carbon::parse($data['end_date'])->format('Y-m-d'),
            'discount' => isset($data['discount'])?$data['discount']:null,
            'discount_type' => isset($data['discount_type'])?$data['discount_type']:null,
            'for_member' => isset($data['for_member'])?$data['for_member']:null,
            'for_all' => isset($data['for_all'])?$data['for_all']:null,
            'maximum_discount' => (isset($data['maximum_discount']) && $data['maximum_discount'] != '')?$data['maximum_discount']:null,
            'minimum_shopping' => isset($data['minimum_shopping'])?$data['minimum_shopping']:null,
            'is_multiple_buy' => isset($data['is_multiple'])?$data['is_multiple']:0
        ]);

        if($data['coupon_type'] == 1){
            foreach($data['product_list'] as $key => $product){
                CouponProduct::create([
                    'coupon_id' => $coupon->id,
                    'coupon_code' => $data['coupon_code'],
                    'product_id' => $product,
                    'for_member' => isset($data['for_member'])?$data['for_member']:null,
                    'for_all' => isset($data['for_all'])?$data['for_all']:null,
                ]);
            }
        }

        if($data['coupon_type'] == 4){
            foreach($data['brand_list'] as $key => $brand){
                CouponBrand::create([
                    'coupon_id' => $coupon->id,
                    'coupon_code' => $data['coupon_code'],
                    'brand_id' => $brand,
                    'for_member' => isset($data['for_member'])?$data['for_member']:null,
                    'for_all' => isset($data['for_all'])?$data['for_all']:null,
                ]);
            }
        }

        return true;
    }

    public function update($data){

        $coupon = Coupon::findOrFail($data['id']);
        if($coupon->coupon_type== 3){
            $data['discount'] = 20;
        }
        $coupon->update([
            'title' => $data['coupon_title'],
            'coupon_code' => $data['coupon_code'],
            'start_date' => Carbon::parse($data['start_date'])->format('Y-m-d'),
            'end_date' => Carbon::parse($data['end_date'])->format('Y-m-d'),
            'discount' => isset($data['discount'])?$data['discount']:null,
            'discount_type' => isset($data['discount_type'])?$data['discount_type']:null,
            'for_member' => isset($data['for_member'])?$data['for_member']:null,
            'for_all' => isset($data['for_all'])?$data['for_all']:null,
            'maximum_discount' => (isset($data['maximum_discount']) && $data['maximum_discount'] != '')?$data['maximum_discount']:null,
            'minimum_shopping' => isset($data['minimum_shopping'])?$data['minimum_shopping']:null,
            'is_multiple_buy' => isset($data['is_multiple'])?$data['is_multiple']:0
        ]);

        $coupon = Coupon::findOrFail($data['id']);
        if($coupon->coupon_type == 1){
            $notselectpro = CouponProduct::where('coupon_id',$coupon->id)->whereNotIn('product_id',$data['product_list'])->pluck('id');
            CouponProduct::destroy($notselectpro);
            foreach($data['product_list'] as $key => $product){
               CouponProduct::where('coupon_id',$coupon->id)->updateOrCreate([
                    'coupon_id' => $coupon->id,
                    'coupon_code' => $data['coupon_code'],
                    'product_id' => $product,
                    'for_member' => isset($data['for_member'])?$data['for_member']:null,
                    'for_all' => isset($data['for_all'])?$data['for_all']:null,
                ]);
           
            }
        }

        if($coupon->coupon_type == 4){
            $notselectpro = CouponBrand::where('coupon_id',$coupon->id)->whereNotIn('brand_id',$data['brand_list'])->pluck('id');
            CouponBrand::destroy($notselectpro);
            foreach($data['brand_list'] as $key => $brand){
                // dd('asfsaasfsfs');
                CouponBrand::where('coupon_id',$coupon->id)->updateOrCreate([
                    'coupon_id' => $coupon->id,
                    'coupon_code' => $data['coupon_code'],
                    'brand_id' => $brand,
                    'for_member' => isset($data['for_member'])?$data['for_member']:null,
                    'for_all' => isset($data['for_all'])?$data['for_all']:null,
                ]);
            }
        }
        return true;
    }

    public function editById($id){
        $seller_id = getParentSellerId();
        return Coupon::with(['products.product.seller','products.product.seller.role','products.product.product'])->where('id', $id)->where('created_by', $seller_id)->firstOrFail();
    }

    public function deleteById($id){
        // dd($id);
        $coupon = Coupon::findOrFail($id);
        if($coupon->coupon_type == 1){
            $products = $coupon->products->pluck('id');
            CouponProduct::destroy($products);
        }
        $coupon->delete();

        return true;
    }
}
