<?php

namespace Modules\Product\Imports;

use Modules\Product\Entities\Product;
use Modules\Product\Entities\ProductSku;
use Modules\Product\Entities\ProductVariations;
use Modules\Product\Entities\ProductTag;
use Modules\Product\Entities\Attribute;
use Modules\Product\Entities\AttributeValue;
use Modules\Shipping\Entities\ProductShipping;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Modules\Product\Entities\CategoryProduct;
use Modules\Seller\Entities\SellerProduct;
use Modules\Seller\Entities\SellerProductSKU;
use Modules\Product\Entities\ProductGalaryImage;
use Modules\Product\Entities\DigitalFile;
use Modules\Setup\Entities\Tag;
use App\Traits\ImageStore;
use App\Models\MediaManager;
use App\Models\UsedMedia;

class ProductImport implements ToCollection, WithHeadingRow
{
    use ImageStore ;

    public function collection(Collection $rows)
    { 
        foreach ($rows as $row){
          

        if(isset($row['product_type']) && $row['product_type'] == 1){ 

        $finalDate = null;

        if(isset($row['new_tag'])){   
            $date = (($row['new_tag'] - 25569) * 86400) ;
            $excelDate = (25569 + ($date / 86400)) ;
            $normalDate = (($excelDate - 25569) * 86400) ;
            $finalDate = gmdate("Y-m-d", $normalDate);
        }

        $product = Product::where('product_name',$row['product_name'])->first();
            if(!$product){
          
            $product = Product::create([
                'product_name'    => $row['product_name'],
                'product_type'    => 1,
                'unit_type_id'    => $row['unit_type_id'],
                'brand_id'    =>   $row['brand_id'],
                'model_number'    => $row['model_number'] ?? '',
                'shipping_cost'    => $row['shipping_cost'] ?? 0,
                'discount_type'    => $row['discount_type'],
                'discount'    => $row['discount'] ?? 1,
                'tax_type'    => $row['tax_type'] ?? 1,
                'tax'    =>   $row['tax'] ?? 0,
                'description'    => $row['description'],
                'specification'    => $row['specification'],
                'minimum_order_qty'    => $row['minimum_order_qty'],
                'is_physical'    => $row['is_physical'],
                'meta_title'    => $row['meta_title'],
                'meta_description'    => $row['meta_description'],
                'slug'    => $row['slug'],
                'is_approved' => 1,
                'media_ids'=> $row['media_ids'] ?? '',
                'gender' => $row['gender'],
                'stock_manage' => $row['stock_manage'],
                'display_in_details' => 1,
                'subtitle_1' => $row['subtitle_1'] ?? '',
                'subtitle_2' => $row['subtitle_2'] ?? '',
            ]);



            // $tags = explode(',', $row['tags']);
            // foreach ($tags as $key => $tag) {
            //     if(!empty($tag)){
            //     $product_tag = new ProductTag;
            //     $product_tag->product_id = $product->id;
            //     $product_tag->tag_id = $tag;
            //     $product_tag->save();
            //     }
            // }

            if ($row['is_physical'] == 0 && isset($row['file_source'])) {
                $digital_product->create([
                    'product_sku_id' => $product_sku->id,
                    'file_source' => $row['file_source'],
                ]);
            }

            $category_ids = explode(',', $row['category_id']);
            foreach ($category_ids as $key => $category_id) {
                $category_product = new CategoryProduct();
                $category_product->product_id = $product->id;
                $category_product->category_id = $category_id;
                $category_product->save();
            }

            ProductShipping::create([
                'shipping_method_id' => 2,
                'product_id' => $product->id
            ]);

            $words = explode(" ", $row['product_name'],);
            $acronym = "";
            foreach ($words as $w) {
                $acronym .= $w[0];
            }

            if($row['tags']){
            $tags = [];
            $tags = explode(',', $row['tags']);
            foreach ($tags as $key => $tag) {
            $tag = Tag::where('name', $tag)->updateOrCreate([
                'name' => strtolower($tag)
            ]);
            ProductTag::create([
                'product_id' => $product->id,
                'tag_id' => $tag->id,
            ]);
            }
        }

            $product_sku = new ProductSku;
            $product_sku->product_id = $product->id;
            $product_sku->track_sku = $acronym;
            $product_sku->selling_price = $row['selling_price'];
            $product_sku->vip_member_price = $row['vip_price'] ?? 0;
            $product_sku->vip_status = $row['vip_status'] ?? 0;
            $product_sku->additional_shipping = $row['additional_shipping'] ?? 0;
            $product_sku->product_stock = $row['stock'];
            $product_sku->vip_product = $row['vip_product'];
            $product_sku->new_tag = $finalDate ;
            $product_sku->status = 1;
            $product_sku->save();

            $sellerProduct = SellerProduct::create([
                'product_id' => $product->id,
                'product_name' => $product->product_name,
                'stock_manage' => $product->stock_manage ?? 0,
                'tax' => $product->tax,
                'tax_type' => $product->tax_type,
                'discount' => $product->discount,
                'discount_type' => $product->discount_type,
                'gender' => $product->gender,
                'is_digital' => 0,
                'user_id' => 1,
                'slug' => strtolower(str_replace(' ', '-', $product->product_name)).'-'.rand(111,999) . '-' . 1,
                'is_approved' => 1,
                'status' => 1,
            ]);
            
            if(isset($row['media_ids']) && $row['media_ids']){
                $attribute = MediaManager::where('id',$row['media_ids'])->first();
            }

            if ($row['media_ids'] != null) {
            $media_ids = explode(',',$row['media_ids']);
            foreach ($media_ids as $i => $image) {
                $product_galary_image = new ProductGalaryImage;
                $product_galary_image->product_id = $product->id;
                $product_galary_image->images_source = $attribute->file_name;
                $product_galary_image->media_id = $media_ids[$i];
                $product_galary_image->save();
              }
            }
            
            SellerProductSKU::create([
                'user_id' => 1,
                'product_id' => $sellerProduct->id,
                'product_sku_id' => $product_sku->id,
                'selling_price' => $product_sku->selling_price,
                'vip_member_price' => $product_sku->vip_member_price ?? 0,
                'vip_status' => $product_sku->vip_status ?? 0,
                'product_stock' => $product_sku->product_stock ?? 0,
                'new_tag' => $product_sku->new_tag ?? 0, 
                'status' => 1
            ]);

        }else {

        $product->unit_type_id = $row['unit_type_id'];
        $product->brand_id = $row['brand_id'];
        $product->model_number = $row['model_number'] ?? '';
        $product->shipping_cost = $row['shipping_cost'] ?? 0;
        $product->discount_type = $row['discount_type'];
        $product->discount = $row['discount'] ?? 1;
        $product->tax_type = $row['tax_type'] ?? 1;
        $product->tax = $row['tax'] ?? 0;
        $product->description = $row['description'];
        $product->specification = $row['specification'];
        $product->minimum_order_qty = $row['minimum_order_qty'];
        $product->is_physical = $row['is_physical'];
        $product->meta_title = $row['meta_title'];
        $product->meta_description = $row['meta_description'];
        $product->slug = $row['slug'];
        $product->is_approved = 1;
        $product->media_ids = $row['media_ids'] ?? '';
        $product->subtitle_1 = $row['subtitle_1'] ?? '';
        $product->subtitle_2  = $row['subtitle_2'] ?? '';
        $product->update();

        // $category_ids = explode(',', $row['category_id']);
        // foreach ($category_ids as $key => $category_id) {
        //     $category_product = CategoryProduct::where('product_id', $product->id)->where('category_id', $category_id)->first();
        //     if($category_product){
        //         $category_product->product_id = $product->id;
        //         $category_product->category_id = $category_id;
        //         $category_product->update();
        //     }else{
        //         $category_product = new CategoryProduct();
        //         $category_product->product_id = $product->id;
        //         $category_product->category_id = $category_id;
        //         $category_product->save();
        //     }
        // }

        $category_ids = explode(',', $row['category_id']);
        $category_product = CategoryProduct::where('product_id', $product->id)->get();
        $dataToArray = $category_product->toArray();
        $table_category = array_column($dataToArray, 'category_id');
      
        $insertDiffs = array_diff($category_ids,$table_category);
        $deleteDiffs = array_diff($table_category,$category_ids);

        if(count($deleteDiffs) > 0){
            foreach ($deleteDiffs as $key => $deleteDiff) {
                $deleteProduct = CategoryProduct::where('product_id', $product->id)->where('category_id',$deleteDiff)->first();
                $deleteProduct->delete();
          }
        }
        if(count($insertDiffs) > 0){
            foreach ($insertDiffs as $key => $insertDiff) {
            $category_product = CategoryProduct::where('product_id', $product->id,$insertDiff)->first();
                if(!$category_product){
                   $category_product = new CategoryProduct();
                   $category_product->product_id = $product->id;
                   $category_product->category_id = $insertDiff;
                   $category_product->save();
                }
            }
        }

        $category_ids = explode(',', $row['category_id']);
            foreach ($category_ids as $key => $category_id) {
                $category_product = new CategoryProduct();
                $category_product->product_id = $product->id;
                $category_product->category_id = $category_id;
                $category_product->save();
            }

        // dd($category_product);
        // dd($category_ids , "categoty id");
        // ProductShipping::update([
        //  'shipping_method_id' => 2,
        //  'product_id' => $product->id
        // ]);

        if(isset($row['media_ids']) && $row['media_ids']){
            $attribute = MediaManager::where('id',$row['media_ids'])->first();
        }

            if ($row['media_ids'] != null) {
            $media_ids = explode(',',$row['media_ids']);
            foreach ($media_ids as $i => $image) {
                $product_galary_image = new ProductGalaryImage;
                $product_galary_image->product_id = $product->id;
                $product_galary_image->images_source = $attribute->file_name;
                $product_galary_image->media_id = $media_ids[$i];
                $product_galary_image->update();
              }
            }

        $words = explode(" ", $row['product_name'],);
        $acronym = "";
        foreach ($words as $w) {
            $acronym .= $w[0];
        }

        $product_sku = ProductSku::where('product_id',$product->id)->first();
        $product_sku->product_id = $product->id;
        $product_sku->track_sku = $acronym;
        $product_sku->selling_price = $row['selling_price'];
        $product_sku->vip_member_price = $row['vip_price'] ?? 0;
        $product_sku->vip_status = $row['vip_status'] ?? 0;
        $product_sku->additional_shipping = $row['additional_shipping'] ?? 0;
        //$product_sku->product_stock = $row['stock'];
        $product_sku->vip_product = $row['vip_product'];
        $product_sku->new_tag = $finalDate ;
        $product_sku->gender = $row['gender'] ?? '';
        $product_sku->status = 1;
        $product_sku->update();

        $sellerProduct = SellerProduct::where('product_id',$product->id)->first();
        $sellerProduct->product_id = $product->id;
        $sellerProduct->product_name = $row['product_name'];
        $sellerProduct->stock_manage = 0;
        $sellerProduct->tax = $row['tax'];
        $sellerProduct->tax_type = $row['tax_type'];
        $sellerProduct->discount = $row['discount'];
        $sellerProduct->discount_type = $row['discount_type'];
        // $sellerProduct->is_physical = 1;
        $sellerProduct->user_id = 1;
        $sellerProduct->slug = strtolower(str_replace(' ', '-', $product->product_name)).'-'.rand(111,999) . '-' . 1;
        $sellerProduct->is_approved = 1;
        $sellerProduct->status = 1;
        $sellerProduct->gender = $row['gender'];
        $sellerProduct->update();

        // $sellerProductSku = SellerProductSKU::where('product_id',$product->id)->first();
        //  dd($sellerProductSku);
        // $sellerProductSku->user_id = 1;
        // $sellerProductSku->product_id = $sellerProduct->id;
        // $sellerProductSku->product_sku_id = $product_sku->id;
        // $sellerProductSku->selling_price = $product_sku->selling_price;
        // $sellerProductSku->vip_member_price = $product_sku->vip_member_price ?? 0;
        // $sellerProductSku->vip_status = $product_sku->vip_status ?? 0;
        // $sellerProductSku->status = 1;
        // $sellerProductSku->update();
    }
}

    if(isset($row['product_type']) && $row['product_type'] == 2){

        $product = Product::where('product_name',$row['product_name'])->first();

        if(!$product){
                $product = Product::create([
                'product_name'    => $row['product_name'],
                'product_type'    => 2,
                'unit_type_id'    => $row['unit_type_id'],
                'brand_id'        => $row['brand_id'],
                'model_number'    => $row['model_number'] ?? '',
                'shipping_cost'   => $row['shipping_cost'] ?? 0,
                'discount_type'   => $row['discount_type'],
                'discount'    => $row['discount'] ?? 1,
                'tax_type'    => $row['tax_type'] ?? 1,
                'tax'    => $row['tax'] ?? 0,
                'description'    => $row['description'],
                'specification'    => $row['specification'],
                'minimum_order_qty'    => $row['minimum_order_qty'],
                'meta_title'    => $row['meta_title'],
                'meta_description'    => $row['meta_description'],
                'slug'    => $row['slug'],
                'is_approved' => 1,
                'media_ids'=>$row['media_ids'] ?? '',
                'gender' => $row['gender'],
            ]);
                $sellerProductName = $product->product_name;
                $sellerProduct = SellerProduct::create([
                'product_id' => $product->id,
                'product_name' => $product->product_name,
                'stock_manage' => 1,
                'tax' => 0,
                'tax_type' => 0,
                'discount' => $product->discount,
                'discount_type' => $product->discount_type,
                'is_digital' => ($product->is_physical == 0) ? 0 : 1,
                'user_id' => 1,
                'slug' => $product->slug,
                'is_approved' => 1,
                'status' => 1,
                'subtitle_1' => "",
                'subtitle_2' => '',
                'gender' => $product->gender,
            ]);
            $words = explode(" ", $product->product_name);
            $acronym = "";
            foreach ($words as $w) {
                $acronym .= $w[0];
            }
                $selling_price = explode(',', $row['selling_price']);
                $vip_member_price = explode(',', $row['vip_price']);
                $variant_image = explode(',', $row['variant_image']);
                        $attribute_value_id = explode(',', $row['variants_id']);
                $stock = explode(',', $row['stock']);
            if(isset($row['attribute']) && $row['attribute']){
                $attribute = Attribute::where('name',$row['attribute'])->first();
                    if($attribute){
                            foreach ($attribute_value_id as $k => $value) {
                                $attributeValue = AttributeValue::where('id',$value)->first();

                                if($attributeValue){
                                       $trskc = str_replace(" ","", $attributeValue->value);
                                       $tracj_sku = $acronym.'-'.$trskc;
                                        $product_sku = new ProductSku;
                                        $product_sku->product_id = $product->id;
                                        $product_sku->track_sku = $tracj_sku;
                                        $product_sku->sku = $tracj_sku;
                                        $product_sku->weight = isset($row['weight'])?$row['weight']:0;
                                        $product_sku->length = isset($row['length'])?$row['length']:0;
                                        $product_sku->breadth = isset($row['breadth'])?$row['breadth']:0;
                                        $product_sku->height = isset($row['height'])?$row['height']:0;
                                      
                                        $product_sku->selling_price = isset($selling_price[$k]) ? $selling_price[$k] : 0 ;
                                        $product_sku->vip_member_price = isset($vip_member_price[$k]) ? $vip_member_price[$k]: 0;
                                        $product_sku->vip_status = isset($vip_member_price[$k]) ? 1:0;
                                        $product_sku->additional_shipping = $row['additional_shipping'] ?? 0;
                                            

                                    $product_sku->status =  0;
                                     $product_sku->product_stock = isset($stock[$k]) ? $stock[$k] : 1;
                                     $product_sku->save();
                                                      $product_sku_update = ProductSku::find($product_sku->id);  
                                        if (isset($variant_image[$k])) {

                                                        $media_img = MediaManager::find($variant_image[$k]);
                                                        if($media_img){
                                                            if($media_img->storage == 'local'){
                                                                $file = asset_path($media_img->file_name);
                                                            }else{
                                                                $file = $media_img->file_name;
                                                            }
                                                            $variant_image = ImageStore::saveImage($file,600,545);
                                                            $product_sku_update->variant_image = $variant_image;
                                                                if (isset($variant_image[$k])) {
                                                                    UsedMedia::create([
                                                                        'media_id' => $media_img->id,
                                                                        'usable_id' => $product_sku->id ?? 0,
                                                                        'usable_type' => get_class($product_sku),
                                                                        'used_for' => 'variant_image'
                                                                    ]);
                                                                }
                                                        }
                                                    } else {
                                                        $product_sku_update->variant_image = null;
                                                    }

                                $product_sku_update->update();
                                $product_variation = new ProductVariations;
                                $product_variation->product_id = $product->id;
                                $product_variation->product_sku_id = $product_sku->id;
                                $product_variation->attribute_id = $attribute->id;
                                $product_variation->attribute_value_id = $attribute_value_id[$k];
                                $product_variation->save();

                                  SellerProductSKU::create([
                                        'product_id' => $sellerProduct->id,
                                        'product_sku_id' => $product_sku_update->id,
                                        'product_stock' => $product_sku_update->product_stock,
                                        'selling_price' => $product_sku_update->selling_price,
                                        'vip_member_price' => $product_sku_update->vip_member_price,
                                        'vip_status' => $product_sku_update->vip_status,
                                        'status' => 1,
                                        'user_id' => 1
                                    ]);

                                }
                        }
                    }
                }
        
            if(isset($row['media_ids']) && $row['media_ids']){
                $attribute = MediaManager::where('id',$row['media_ids'])->first();
                }

        
            if ($row['media_ids'] != null) {
            $media_ids = explode(',',$row['media_ids']);
            foreach ($media_ids as $i => $image){
                $product_galary_image = new ProductGalaryImage;
                $product_galary_image->product_id = $product->id;
                $product_galary_image->images_source = $attribute->file_name;
                $product_galary_image->media_id = $media_ids[$i];
                $product_galary_image->save();
              }
            }            

            $category_ids = explode(',', $row['category_id']);
            foreach ($category_ids as $key => $category_id) {
                $category_product = new CategoryProduct();
                $category_product->product_id = $product->id;
                $category_product->category_id = $category_id;
                $category_product->save();
            }
          }else{
            
                $product->product_name = $row['product_name'];
                $product->product_type = 2;
                $product->unit_type_id = $row['unit_type_id'];
                $product->brand_id = $row['brand_id'];
                $product->model_number = $row['model_number'] ?? '';
                $product->shipping_cost = $row['shipping_cost'] ?? 0;
                $product->discount_type = $row['discount_type'];
                $product->discount = $row['discount'] ?? 1;
                $product->tax_type = $row['tax_type'] ?? 1;
                $product->tax = $row['tax'] ?? 0;
                $product->description = $row['description'];
                $product->specification = $row['specification'];
                $product->minimum_order_qty = $row['minimum_order_qty'];
                $product->meta_title = $row['meta_title'] ;
                $product->meta_description = $row['meta_description'];
                $product->slug = $row['slug'];
                $product->is_approved = 1;
                $product->media_ids = $row['media_ids'];
                $product->update();

                // dd($product);

            $words = explode(" ", $product->product_name);
            $acronym = "";
            foreach ($words as $w) {
                $acronym .= $w[0];
            }
                $selling_price = explode(',', $row['selling_price']);
                $vip_member_price = explode(',', $row['vip_price']);
                $variant_image = explode(',', $row['variant_image']);
                        $attribute_value_id = explode(',', $row['variants_id']);
                $stock = explode(',', $row['stock']);
            if(isset($row['attribute']) && $row['attribute']){
                $attribute = Attribute::where('name',$row['attribute'])->first();
                    if($attribute){
                            foreach ($attribute_value_id as $k => $value) {
                                $attributeValue = AttributeValue::where('id',$value)->first();

                                if($attributeValue){
                                    $trskc = str_replace(" ","", $attributeValue->value);
                                    $tracj_sku = $acronym.'-'.$trskc;
                                    $product_sku = new ProductSku;
                                    $product_sku->product_id = $product->id;
                                    $product_sku->track_sku = $tracj_sku;
                                    $product_sku->sku = $tracj_sku;
                                    $product_sku->weight = isset($row['weight'])?$row['weight']:0;
                                    $product_sku->length = isset($row['length'])?$row['length']:0;
                                    $product_sku->breadth = isset($row['breadth'])?$row['breadth']:0;
                                    $product_sku->height = isset($row['height'])?$row['height']:0; 
                                    $product_sku->selling_price = isset($selling_price[$k]) ? $selling_price[$k] : 0 ;
                                    $product_sku->vip_member_price = isset($vip_member_price[$k]) ? $vip_member_price[$k]: 0;
                                    $product_sku->vip_status = isset($vip_member_price[$k]) ? 1:0;
                                    $product_sku->additional_shipping = $row['additional_shipping'] ?? 0;        
                                    $product_sku->status =  0;
                                    $product_sku->product_stock = isset($stock[$k]) ? $stock[$k] : 1;
                                    $product_sku->save();
                                    $product_sku_update = ProductSku::find($product_sku->id);  
                                        if (isset($variant_image[$k])) {
                                                        $media_img = MediaManager::find($variant_image[$k]);
                                                        if($media_img){
                                                            if($media_img->storage == 'local'){
                                                                $file = asset_path($media_img->file_name);
                                                            }else{
                                                                $file = $media_img->file_name;
                                                            }
                                                            $variant_image = ImageStore::saveImage($file,600,545);
                                                            $product_sku_update->variant_image = $variant_image;
                                                                if (isset($variant_image[$k])) {
                                                                    UsedMedia::create([
                                                                        'media_id' => $media_img->id,
                                                                        'usable_id' => $product_sku->id ?? 0,
                                                                        'usable_type' => get_class($product_sku),
                                                                        'used_for' => 'variant_image'
                                                                    ]);
                                                                }
                                                        }
                                                    } else {
                                                        $product_sku_update->variant_image = null;
                                                    }

                                     $product_sku_update->update();

                                $product_variation = ProductVariations::where('product_id',$product->id)->first();
                                // dd($product_variation);
                                $product_variation->product_id = $product->id;
                                $product_variation->product_sku_id = $product_sku->id;
                                $product_variation->attribute_id = $attribute->id;
                                $product_variation->attribute_value_id = $attribute_value_id[$k];
                                $product_variation->save();

                                }
                        }
                    }
                }
        
                if(isset($row['media_ids']) && $row['media_ids']){
                $attribute = MediaManager::where('id',$row['media_ids'])->first();
                }

            if ($row['media_ids'] != null) {
            $media_ids = explode(',',$row['media_ids']);
            foreach ($media_ids as $i => $image){
                $product_galary_image = new ProductGalaryImage;
                $product_galary_image->product_id = $product->id;
                $product_galary_image->images_source = $attribute->file_name;
                $product_galary_image->media_id = $media_ids[$i];
                $product_galary_image->save();
              }
            }            

            // $category_ids = explode(',', $row['category_id']);
            // foreach ($category_ids as $key => $category_id) {
            //     $category_product = CategoryProduct::find($category_id);
            //     $category_product->product_id = $product->id;
            //     $category_product->category_id = $category_id;
            //     $category_product->update();
            // }

          }
        }
       }
      }
    } 
 