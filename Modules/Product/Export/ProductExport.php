<?php

namespace Modules\Product\Export;

use Illuminate\Support\Facades\DB;
// use Modules\Product\Entities\Product;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Modules\Product\Entities\Product;
use Modules\Product\Entities\ProductSku;
use Modules\Product\Entities\AttributeValue;
use Modules\Product\Entities\CategoryProduct;
use Modules\Product\Entities\Attribute;
use Modules\Product\Entities\ProductVariations;
use Modules\Product\Entities\ProductTag;

class ProductExport implements FromCollection, WithHeadings,WithMapping
{
    use Exportable;
    public function collection()
    {
        return Product::get();
    }


    public function map($product): array
    {

    $categories = CategoryProduct::select('category_id')->where('product_id',$product->id)->get()->toArray();
    $categories = array_column($categories, 'category_id');
    $categories_id = implode(',',$categories);

    $attributes = AttributeValue::select('id')->where('attribute_id',$product->id)->get()->toArray();
    $attributes = array_column($attributes, 'id');
    $attributes_id = implode(",", $attributes);

    $skus = ProductSku::select('product_stock')->where('product_id',$product->id)->get()->toArray();
    $skus = array_column($skus, 'product_stock');
    $stock = implode(',',$skus);

    $skus = ProductSku::select('selling_price')->where('product_id',$product->id)->get()->toArray();
    $skus = array_column($skus, 'selling_price');
    $selling_price = implode(',',$skus);

    $skus = ProductSku::select('vip_member_price')->where('product_id',$product->id)->get()->toArray();
    $skus = array_column($skus, 'vip_member_price');
    $vip_member_price = implode(',',$skus);

    $skus = ProductSku::select('vip_status')->where('product_id',$product->id)->get()->toArray();
    $skus = array_column($skus, 'vip_status');
    $vip_status = implode(',',$skus);

    $skus = ProductSku::select('vip_product')->where('product_id',$product->id)->get()->toArray();
    $skus = array_column($skus, 'vip_product');
    $vip_product = implode(',',$skus);

    $skus = ProductSku::select('new_tag')->where('product_id',$product->id)->get()->toArray();
    $skus = array_column($skus, 'new_tag');
    $new_tag = implode(',',$skus);
   
    $skus = ProductSku::select('additional_shipping')->where('product_id',$product->id)->get()->toArray();
    $skus = array_column($skus, 'additional_shipping');
    $additional_shipping = implode(',',$skus);

    $varients_imae = [];
    $product_skus = ProductSku::with('variant_image_media')->where('product_id',$product->id)->get();
    // dd($product_skus);
    foreach ($product_skus as $key => $product_sku) {
        if(!empty($product_sku->variant_image_media) && !is_null($product_sku->variant_image_media)){
            foreach ($product_sku->variant_image_media as $key => $variant_image_media) {
                // dd($product_sku->variant_image_media->media_id);
                if($product_sku->variant_image_media->media_id){
                array_push($varients_imae,$product_sku->variant_image_media->media_id);
                }
            }
        }
    }

    $variant_image_id = implode(',',$varients_imae);
    // dd($variant_image_id);
    // dd("peter");

    $skus = array_column($skus, 'additional_shipping');
    $additional_shipping = implode(',',$skus);

    $medias = Product::select('media_ids')->where('id',$product->id)->get()->toArray();
    $medias = array_column($medias, 'media_ids');
    $media_ids = implode(',',$medias);

    $attributes = ProductVariations::select('attribute_id')->where('product_id',$product->id)->get()->toArray();
    $attributes = array_column($attributes, 'attribute_id');
    $attribute_ids = implode(',',$attributes);

    $varients = ProductVariations::select('attribute_value_id')->where('product_id', $product->id)->get()->toArray();
    $varients = array_column($varients, 'attribute_value_id');
    $varient_id = implode(',',$varients);

    $tags = ProductTag::select('tag_id')->where('product_id', $product->id)->get()->toArray();
    $tags = array_column($tags, 'tag_id');
    $tags_id = implode(',',$tags);

        return [
            $product->id,
            $product->product_name,
            $product->product_type,
            $product->unit_type_id,
            $product->brand_id,
            $categories_id,
            $product->model_number,
            $product->gender,
            $product->shipping_cost,
            $product->discount_type,
            $product->discount,
            $product->tax_type,
            $product->stock_manage,
            $product->tax,
            $product->description,
            $product->specification,
            $product->minimum_order_qty,
            $product->meta_title,
            $product->meta_description,
            $product->slug,
            $tags_id,
            $product->track_sku,
            $product->is_physical,
            $attribute_ids,
            $varient_id,
            $stock,
            $vip_status,
            $vip_member_price,
            $vip_product,
            $selling_price,
            $new_tag,
            $product->subtitle_1,
            $product->subtitle_2,
            $additional_shipping,
            $media_ids,
            $variant_image_id
        ];
    }
    public function headings(): array
    {
        return [
            'id',
            'product_name',
            'product_type',
            'unit_type_id',
            'brand_id',
            'category_id',
            'model_number',
            'gender',
            'shipping_cost',
            'discount_type',
            'discount',
            'tax_type',
            'stock_manage',
            'tax',
            'description',
            'specification',
            'minimum_order_qty',
            'meta_title',
            'meta_description',
            'slug',
            'tags',
            'track_sku',
            'is_physical',
            'attribute',
            'variants_id',
            'stock',
            'vip_status',
            'vip_price',
            'vip_product',
            'selling_price',
            'new_tag',
            'subtitle_1',
            'subtitle_2',
            'additional_shipping',
            'media_ids',
            'variant_image',
        ];
    }
}
