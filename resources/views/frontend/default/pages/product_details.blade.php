@extends('frontend.default.layouts.app')
@section('styles')
    <link rel="stylesheet" href="{{asset(asset_path('frontend/default/css/page_css/product_details.css'))}}" />
  <meta name="csrf-token" content="{{ csrf_token() }}" />
    @if(isRtl())
        <style>
            /* .zoomWindowContainer div {
                left: 0!important;
                right: 20px;
            }
            .product_details_part .cs_color_btn .radio input[type="radio"] + .radio-label:before {
                left: -1px !important;
            }
            @media (max-width: 970px) {
                .zoomWindowContainer div {
                    right: inherit!important;
                }
            } */
        </style>
    @endif
@endsection

@section('title')
    @if(@$product->product->meta_title != null)
        {{ @substr(@$product->product->meta_title,0, 60)}}
    @else
        {{ @substr(@$product->product_name,0, 60)}}
    @endif
@endsection

@section('share_meta')
    
    @if(@$product->product->meta_description != null)
        <meta property="og:description" content="{{@$product->product->meta_description}}" />
        <meta name="description" content="{{@$product->product->meta_description}}">
    @else
        <meta property="og:description" content="{{@$product->product->description}}" />
        <meta name="description" content="{{@$product->product->description}}">
    @endif

    @if(@$product->product->meta_title != null)
        <meta name="title" content="{{ @substr(@$product->product->meta_title,0,60) }}"/>
        <meta property="og:title" content="{{substr(@$product->product->meta_title,0,60)}}" />
    @else
        <meta property="og:title" content="{{@substr(@$product->product_name,0,60)}}" />
        <meta name="title" content="{{ @substr(@$product->product_name,0,60) }}"/>
    @endif

    @if(@$product->product->meta_image != null && @getimagesize(showImage(@$product->product->meta_image))[0] > 200)
        
        <meta property="og:image" content="{{showImage($product->product->meta_image)}}" />
    @elseif(@$product->product->thumbnail_image_source != null && @getimagesize(showImage(@$product->product->thumbnail_image_source))[0] > 200)
    
        <meta property="og:image" content="{{showImage(@$product->product->thumbnail_image_source)}}" />
    @elseif(count(@$product->product->gallary_images) > 0 && @getimagesize(showImage(@$product->product->gallary_images[0]->images_source))[0] > 200)
        <meta property="og:image" content="{{showImage(@$product->product->gallary_images[0]->images_source)}}" />
        
    @endif
    <meta property="og:url" content="{{singleProductURL(@$product->seller->slug, $product->slug)}}" />
    <meta property="og:image:width" content="400" />
    <meta property="og:image:height" content="300" />
    <meta property="og:type" content="{{@$product->product->meta_description}}" />

    
    @php
        $total_tag = count($product->product->tags);
        $meta_tags = '';
        foreach($product->product->tags as $key => $tag){
            if($key + 1 < $total_tag){
                $meta_tags .= $tag->name.', ';
            }else{
                $meta_tags .= $tag->name;
            }
        }
    @endphp

    <meta name ="keywords", content="{{$meta_tags}}">
@endsection


  <style>
    /* .fade:not(.show) {
    opacity: 1;
}

    #big-img{
      z-index: 99999;
    } */
    .product_details_img .fade:not(.show){
        display: none;
    }
    
  </style>

@section('content')

@if(session('success'))
    <script type="text/javascript">
     Swal.fire({
     icon: 'success',
     title: 'Review submitted successfully',
     timer: 2000,
     })
    </script>
  @endif
  @if(session('error'))
    <script type="text/javascript">
     Swal.fire({
     icon: 'error',
     title: 'Something Went Wrong',
     timer: 2000,
     })
    </script>
  @endif

<!-- product New-details start -->
<div class="productdetails_pages pt-50 pb-50">
  <div class="container">
<!-- <div class="col-lg-1"></div> -->
  <div class="row">
    <!-- <div class="col-lg-1 product_details_small_img">
         <ul class="nav nav-pills small_img" id="pills-tab" role="tablist">
            <li class="nav-item">
                <a class="nav-link active mini_img" id="pills-home-tab" data-toggle="pill" href="#pills-home" role="tab" aria-controls="pills-home" aria-selected="true">
                    <img src="https://www.w3schools.com/howto/img_avatar2.png" alt="">
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link mini_img" id="pills-profile-tab" data-toggle="pill" href="#pills-profile" role="tab" aria-controls="pills-profile" aria-selected="false">
                <img src="https://www.w3schools.com/howto/img_avatar2.png" alt="">
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link mini_img" id="pills-contact-tab" data-toggle="pill" href="#pills-contact" role="tab" aria-controls="pills-contact" aria-selected="false">
                <img src="https://www.w3schools.com/howto/img_avatar2.png" alt="">
                </a>
            </li>
        </ul>
    </div>
    <div class="col-lg-4">
        <div class="tab-content contianer_big_img" id="pills-tabContent">
            <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab"> 
                <div class="big_img">
                        <img  src="https://www.w3schools.com/howto/img_avatar2.png" alt="#" class="img-fluid var_img_show zoom_01" />
                    </div>
                </div>
            <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">
            <div class="big_img">
                        <img  src="https://www.w3schools.com/howto/img_avatar2.png" alt="#" class="img-fluid var_img_show zoom_01" />
                    </div>
            </div>
            <div class="tab-pane fade" id="pills-contact" role="tabpanel" aria-labelledby="pills-contact-tab">
            <div class="big_img">
                        <img  src="https://www.w3schools.com/howto/img_avatar2.png" alt="#" class="img-fluid var_img_show zoom_01" />
                    </div>
            </div>
        </div>
    </div>
    <div class="col-lg-5"></div> -->

<div class=col-lg-6>
    <div class='row sticky-top'>
    <div class="col-xl-2 col-lg-2">
                <ul class="nav tab_thumb mini_sidebar" id="pills-tab" role="tablist">
                        @if(count($product->product->gallary_images) > 0 && $product->product->product_type == 1)
                        @foreach($product->product->gallary_images as $image)
                        <li class="nav-item thumb_small_m">
                            <a class="nav-link" id="thumb_{{$image->id}}_tab" data-toggle="tab" href="#thumb_{{$image->id}}" role="tab" aria-controls="thumb_1" aria-selected="false">
                                <div class="thamb_img">
                                    <img src="{{showImage($image->images_source)}}" alt="#" class="img-fluid"/>
                                </div>
                            </a>
                        </li>
                        @endforeach
                        
                        @elseif(count($product->productSKU) > 0 &&  $product->product->product_type == 2 )
                        @foreach($product->productSKU as $image)
                        <li class="nav-item thumb_small_m">
                            <a class="nav-link" id="thumb_{{$image->id}}_tab" data-toggle="tab" href="#thumb_{{$image->id}}" role="tab" aria-controls="thumb_1" aria-selected="false">
                                <div class="thamb_img">
                                    <img src="{{showImage($image->variant_image)}}" alt="#" class="img-fluid"/>
                                </div>
                            </a>
                        </li>
                        @endforeach 
                        @else
                        <li class="nav-item">
                            <a class="nav-link" id="thumb_{{$product->id}}_tab" data-toggle="tab" href="#thumb_{{$product->id}}" role="tab" aria-controls="thumb_1" aria-selected="false">
                                <div class="thamb_img">
                                <img @if ($product->thum_img != null) src="{{showImage($product->thum_img)}}" @else src="{{showImage($product->product->thumbnail_image_source)}}" @endif alt="#" class="img-fluid"/>
                                </div>
                            </a>
                        </li>
                        @endif

                        <input type="hidden" id="product_id" name="product_id" value="{{ $product->id }}">
                        <input type="hidden" id="maximum_order_qty" value="{{@$product->product->max_order_qty}}">
                        <input type="hidden" id="minimum_order_qty" value="{{@$product->product->minimum_order_qty}}">
                    </ul>

            </div>
            <div class="col-lg-10 col-xl-10">
                <div class="product_details_img " id="pills-tabContent">
                    <div class="" id="myTabContent">
                        @if(count($product->product->gallary_images) > 0 && $product->product->product_type == 1 )
                        @foreach($product->product->gallary_images as $image)
                        <div class="gallary_img tab-pane fade {{$product->product->gallary_images->first()->id == $image->id?'show active':''}}" id="thumb_{{$image->id}}" role="tabpanel">
                            <div class="img_div big_img">
                                <img data-zoom-image="{{showImage($image->images_source)}}" src="{{showImage($image->images_source)}}" alt="#" class="img-fluid var_img_show zoom_01" />
                            </div>
                        </div>
                        @endforeach

                        @elseif(count($product->productSKU) > 0 &&  $product->product->product_type == 2 )
                        @foreach($product->productSKU as $image)
                        {{-- {{dd($image->variant_image)}} --}}
                        <div class="gallary_img tab-pane fade {{$product->productSKU->first()->id == $image->id?'show active':''}}" id="thumb_{{$image->id}}" role="tabpanel">
                        <div class="img_div big_img">
                        <img data-zoom-image="{{showImage($image->variant_image)}}" src="{{showImage($image->variant_image)}}" alt="#" class="img-fluid var_img_show zoom_01" />
                            </div>
                        </div>
                        @endforeach

                        @else
                        <div class="tab-pane fade show active" id="thumb_{{$product->id}}" role="tabpanel">
                            <div class="img_div">
                                <img @if ($product->thum_img != null) data-zoom-image="{{showImage($product->thum_img)}}" @else data-zoom-image="{{showImage($product->product->thumbnail_image_source)}}" @endif @if ($product->thum_img != null) src="{{showImage($product->thum_img)}}" @else src="{{showImage($product->product->thumbnail_image_source)}}" @endif alt="" class="img-fluid var_img_show zoom_01" />
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
    </div>
    </div>
      <div class="col-lg-6">
        <div class="details_productright btnwidthcss">
            {{-- @foreach($product->product->categories->where('status', 1) as $key => $category)
                <a style="color:black;" href="{{route('frontend.category-product',['slug' => $category->slug, 'item' =>'category'])}}" class="product_details_btn_iner">{{$category->name}}</a>
            @endforeach --}}
@php 
  $productReviews = \App\Models\Review_product::where('status', 1)->where('product_id',$product->id)->get();
  $productTotalReviews = \App\Models\Review_product::where('status', 1)->where('product_id',$product->id)->count();
  $reviewNumber1 = \App\Models\Review_product::where('status', 1)->where('rating', 1)->where('product_id',$product->id)->count();
  $reviewNumber2 = \App\Models\Review_product::where('status', 1)->where('rating', 2)->where('product_id',$product->id)->count();
  $reviewNumber3 = \App\Models\Review_product::where('status', 1)->where('rating', 3)->where('product_id',$product->id)->count();
  $reviewNumber4 = \App\Models\Review_product::where('status', 1)->where('rating', 4)->where('product_id',$product->id)->count();
  $reviewNumber5 = \App\Models\Review_product::where('status', 1)->where('rating', 5)->where('product_id',$product->id)->count();
  // print_r($product->id);
  if($reviewNumber5>0)
    $rate_five = ceil(($reviewNumber5*100)/$productTotalReviews);
  if($reviewNumber4>0)
    $rate_four = ceil(($reviewNumber4*100)/$productTotalReviews);
  if($reviewNumber3)
    $rate_three = ceil(($reviewNumber3*100)/$productTotalReviews);
  if($reviewNumber2>0)
    $rate_two = ceil(($reviewNumber2*100)/$productTotalReviews);
  if($reviewNumber1>0)
    $rate_one = ceil(($reviewNumber1*100)/$productTotalReviews);
  $total_review_calc = $reviewNumber5*5 + $reviewNumber4*4 + $reviewNumber3*3 + $reviewNumber2*2 + $reviewNumber1*1 ;
  if($total_review_calc>0)
  $show_total = ceil($total_review_calc / $productTotalReviews) ;

@endphp
            <div class="row mb-4">
                <div class="col-md-6">
                    <h2 style="font-size:24px;margin-bottom: 0; font-weight:600">{{$product->product_name}}</h2>
                    <div class='list_varent'>
                        <ul>
                       
                            @php
                                $total_tag = count($product->product->tags);
                            @endphp
                            @foreach($product->product->tags as $key => $tag)
                            <li>
                                <a class="tag_link" target="_blank" href="{{route('frontend.category-product',['slug' => $tag->name, 'item' =>'tag'])}}">{{$tag->name}}</a></li>
                                @if($key + 1 < $total_tag) @endif
                            @endforeach
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-md-6 text-right">
                   
                    <div class="icon_procuct">
                    <!-- <div class="mb-2 clickshare"  title='Share'><i class="fa fa-share-alt" aria-hidden="true"></i></div> -->
                    <div class="clickshare1" title='Write A Review'><a href="#review_area"  class="js-anchor-link"> 4.7 <i class="fa fa-star" aria-hidden="true"></i> </a></div>
                </div>
                </div>
            </div>
            {{-- <div class="row">
                <div class="col-lg-12">
                    <div class="product_count">
                        <input type="text" name="qty[]" id="qty_{{$cart->id}}" class="qty" maxlength="12" value="{{$cart->qty}}" class="input-text qty" readonly/>
                        <input type="hidden" value="{{$cart->id}}" name="cart_id[]">
                        <input type="hidden" id="maximum_qty_{{$cart->id}}" value="{{$cart->product->product->product->max_order_qty}}">
                        <input type="hidden" id="minimum_qty_{{$cart->id}}" value="{{$cart->product->product->product->minimum_order_qty}}">
                        <div class="button-container">
                            <button class="cart-qty-plus change_qty" data-qty_id="#qty_{{$cart->id}}" data-change_amount="1" data-maximum_qty="#maximum_qty_{{$cart->id}}"
                                 data-minimum_qty="#minimum_qty_{{$cart->id}}" data-product_stock="{{$cart->product->product_stock}}" data-stock_manage="{{$cart->product->product->stock_manage}}" type="button" value="+"><i class="ti-plus"></i></button>
                            <button class="cart-qty-minus change_qty" data-qty_id="#qty_{{$cart->id}}" data-change_amount="1" data-maximum_qty="#maximum_qty_{{$cart->id}}"
                                 data-minimum_qty="#minimum_qty_{{$cart->id}}" data-product_stock="{{$cart->product->product_stock}}" data-stock_manage="{{$cart->product->product->stock_manage}}" type="button" value="-"><i class="ti-minus"></i></button>
                        </div>
                    </div>
                </div>
            </div> --}}
          <div class="row align-items-center">
              <div class="col-lg-6">
                    @if(app('general_setting')->product_subtitle_show)
                        @if($product->subtitle_1)
                            <div class="subtitle">
                                <h4 style="font-size: 20px !important; font-weight: 600 !important;">{{$product->subtitle_1}}</h4>
                            </div>
                        @endif
                        @if($product->subtitle_2)
                            <div class="subtitle">
                                <h4 style="font-size: 20px !important; font-weight: 600 !important;">{{$product->subtitle_2}}</h4>
                            </div>
                        @endif
                    @endif
              </div>
          </div>
        
            <div class="price_are  mb-3">
                    <div class="row">
                        <div class="col-md-6 price" style="font-size:20px;" id="varient_price">
                        @if(Auth::user()  &&  Auth::user()->is_membership  && ($product->skus->first()->vip_status == 1))
                           {{--  @if($product->hasDeal)
                                ₹ {{(selling_price($product->skus->first()->vip_member_price,$product->hasDeal->discount_type,$product->hasDeal->discount))}}
                            @elseif($product->discount == 0.0)
                            ₹ {{(@$product->skus->first()->vip_member_price)}}
                            @else
                                @if($product->hasDiscount == 'yes')
                                    ₹ {{(selling_price(@$product->skus->first()->vip_member_price,@$product->discount_type,@$product->discount))}}
                                @else
                                    ₹ {{(@$product->skus->first()->vip_member_price)}}
                                @endif
                            @endif --}}
                            <span class="">₹ {{(selling_price(@$product->skus->first()->vip_member_price ))}}</span>
                        @elseif($product->discount == 0.0 )
                            ₹ {{(@$product->skus->first()->selling_price)}}
                        @else
                            @if($product->hasDeal)
                               ₹ {{(selling_price($product->skus->first()->selling_price,$product->hasDeal->discount_type,$product->hasDeal->discount))}}
                            @else
                                @if($product->hasDiscount == 'yes')
                                   ₹ {{(selling_price(@$product->skus->first()->selling_price,@$product->discount_type,@$product->discount))}}
                                @else
                                   ₹ {{(@$product->skus->first()->selling_price)}}
                                @endif
                            @endif
                            <span class="cutprice">₹ {{(selling_price(@$product->skus->first()->selling_price ))}}
                            </span>
                        @endif
                        </div>
                        <div class="col-md-6" style="font-size:25px;padding-left: 50px;padding-top: 10px;"></div>
                     </div>
                     
                        @if($product->hasDeal || $product->hasDiscount == 'yes')
                            <span></span>
                        @endif</span></p>
                    <div class="row">
                        <div class="col-lg-10">
                            <div class="border-top"></div>
                        </div>
                    </div>    
                    <div class="product_details_content">
                        <ul>
                            @php
                                $stock = 0;
                            @endphp

                            @if ($product->stock_manage == 1)
                                <li style="display:none;">{{__('defaultTheme.availability')}} : <span id="availability">{{ $product->skus->first()->product_stock }}</span></li>
                            @endif
                        
                           {{--  <li>{{__('defaultTheme.sku')}}: <span id="sku_id_li">{{@$product->skus->first()->sku->sku}}</span></li> --}}
                            {{-- <li>{{__('common.category')}} :
                                @php
                                    $cates = count($product->product->categories);
                                @endphp
                                @foreach($product->product->categories as $key => $category)
                                    <span>{{$category->name}}</span>
                                    @if($key + 1 < $cates), @endif
                                @endforeach
                            </li> --}}
                        {{--    <li>{{__('common.tag')}} : <span>
                                @php
                                    $total_tag = count($product->product->tags);
                                @endphp
                                @foreach($product->product->tags as $key => $tag)
                                    <a class="tag_link" target="_blank" href="{{route('frontend.category-product',['slug' => $tag->name, 'item' =>'tag'])}}">{{$tag->name}}</a>
                                    @if($key + 1 < $total_tag), @endif
                                @endforeach
                            </span></li>--}}
                            @if (count($product->skus) > 1)
                            <div class="mb-40">
                            <!-- content  -->
                            <div class="QA_section3 QA_section_heading_custom ">
                              
                                {{-- <div class="QA_table QA_table4">
                                    <!-- table-responsive -->
                                    <div class="table-responsive">
                                        <table class="table shadow_none pb-0 ">
                                            <thead class="tect-center">
                                                <tr>
                                                    <th scope="col">{{__('product.attribute')}}</th>
                                                    <th scope="col">{{__('product.selling_price')}}</th>
                                                    <th scope="col">{{__('Add to Cart')}}</th>
                                                </tr>
                                            </thead>
                                            <tbody class="text-center">
                                                @foreach($product->skus as $key => $sku)
                                                <tr>
                                                    <td>
                                                        @foreach ($sku->product_variations as $key => $variation)
                                                        {{ @$variation->attribute->name }} :
                                                        {{ $variation->attribute_value->color ? @$variation->attribute_value->color->name : @$variation->attribute_value->value }}
                                                        <br>
                                                        @endforeach
                                                    </td>

                                                @php 
                                                $sellr_sku = \Modules\Seller\Entities\SellerProductSKU::where('product_sku_id',$sku->product_sku_id)->first();  
                                                @endphp    

                                                    <td>{{ $sku->selling_price }}</td>
                                        
                                                     <td><button type="button" class="add_to_cart_btn btn btn-link btn-blck-bg" base_sku_price="{{ @$sku->selling_price }}" product_sku_id="{{@$sellr_sku->id}}" class="btn btn-link btn-blck-bg ">{{__('defaultTheme.add_to_cart')}}</button></td>
                                                   
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div> --}}

                                <div class="row">
                                <div class="col-lg-5 hisher_dropdown">
                                    <select class="form-control" id="add_to_cart_btn_select">
                                        @foreach($product->productSKU as $key => $sku)
                                        @php 
                                           $sellr_sku = \Modules\Seller\Entities\SellerProductSKU::where('product_sku_id',$sku->product_sku_id)->first();  
                                        @endphp    
                                        @foreach ($sku->product_variations as $key => $variation)
                                        @php 
                                          $base_price = $sku->selling_price;
                                          if(Auth::user()  &&  Auth::user()->is_membership  && (@$sku->vip_status == 1) && $sku->vip_member_price)
                                          {
                                            $base_price = $sku->vip_member_price;
                                          }

                                        @endphp   
                                        <option

                                         base_sku_price="{{ @$base_price}}" variant-id="{{$sku->id}}"  product_sku_id="{{@$sellr_sku->id}}" value="{{@$variation->attribute_value->value}}"  image="{{showImage($sku->variant_image)}}" >{{@$variation->attribute_value->value}}</option>
                                        @endforeach
                                           @endforeach
                                        
                                    </select>
                                </div> 
                                <div class="col-lg-5">
                                    <div class="single_details_content d-md-flex">
                                    <div class="details_text d-flex">
                                    <div class="product_count">
                                    <input type="text" name="qty" class="qty" id="qty" readonly value="{{@$product->product->minimum_order_qty}}"/>
                                    <div class="button-container">
                                        <button class="cart-qty-plus qtyChange" data-value="+" type="button" value="+">
                                            <i class="ti-plus"></i>
                                        </button>
                                        <button class="cart-qty-minus qtyChange" data-value="-" type="button" value="-">
                                            <i class="ti-minus"></i>
                                        </button>
                                    </div>
                                    </div>
                                    </div>
                                    <input type="hidden" name="product_type" class="product_type" value="{{ $product->product->product_type }}">
                                </div>
                                </div>
                                <div class='col-lg-5'>
                                    <button type="button" id="add_to_cart_btn_variation" class=" btn btn-link btn-blck-bg  mt-3"  class="btn btn-link btn-blck-bg ">{{__('defaultTheme.add_to_cart')}}</button>
                                    </div>
                                    <div class='col-lg-5'>
                                    <a class="btn btn-link btn-wishtlist mt-3 " id="wishlist_btn" data-product_id="{{$product->id}}" data-seller_id="{{$product->user_id}}"> <i class="fa fa-heart-o" aria-hidden="true"></i>
                                {{__('defaultTheme.add_to_wishlist')}}</a>
                                    </div>

                                </div>
                            {{-- <div class='row'>
                                <div class='col-lg-12'>
                                <div class="single_details_content d-md-flex">
                                    <div class="details_text d-flex">
                                    <div class="product_count">
                                    <input type="text" name="qty" class="qty" id="qty" readonly value="{{@$product->product->minimum_order_qty}}"/>
                                    <div class="button-container">
                                        <button class="cart-qty-plus qtyChange" data-value="+" type="button" value="+">
                                            <i class="ti-plus"></i>
                                        </button>
                                        <button class="cart-qty-minus qtyChange" data-value="-" type="button" value="-">
                                            <i class="ti-minus"></i>
                                        </button>
                                    </div>
                                    </div>
                                    </div>
                                    <input type="hidden" name="product_type" class="product_type" value="{{ $product->product->product_type }}">
                                </div>
                                </div>
                            </div> --}}
                             
                                {{-- @endforeach --}}
                               
                                <!-- <div class="col-lg-4 pt-3 pl-0">
                                <td></td>
                                <td> </td>
                                </div>  -->
                                {{-- @endforeach --}}
                            </div>
                            <!--/ content  -->
                                </div>
                            @else
                            {{-- @php
                              $varient_name = @$product->skus->first()->product_variations->first()->attribute_value->value;
                            @endphp --}}
                            @if(@$product->skus->first()->product_variations->first()->attribute_value->value)
                            <li><span>Varient Name : {{@$product->skus->first()->product_variations->first()->attribute_value->value}}</span></li>
                            @endif
                        </ul>
                    </div>
                    <div class='row '>
                        <div class='col-lg-4'>
                            {{-- <div class="quantity">
                                <a href="#" class="quantity__minus" style="background-color:#ba933e;"><span>-</span></a>
                                <input name="quantity" type="text" class="quantity__input" value="1">
                                <a href="#" class="quantity__plus" style="background-color:#ba933e;"><span>+</span></a>
                            </div> --}}
                            <div class="single_details_content d-md-flex">
                                    <div class="details_text d-flex">
                                    <div class="product_count">
                                    <input type="text" name="qty" class="qty" id="qty" readonly value="{{@$product->product->minimum_order_qty}}"/>
                                    <div class="button-container">
                                        <button class="cart-qty-plus qtyChange" data-value="+" type="button" value="+">
                                            <i class="ti-plus"></i>
                                        </button>
                                        <button class="cart-qty-minus qtyChange" data-value="-" type="button" value="-">
                                            <i class="ti-minus"></i>
                                        </button>
                                    </div>
                                    </div>
                                    </div>
                                    <input type="hidden" name="product_type" class="product_type" value="{{ $product->product->product_type }}">
                                </div>
                        </div>
                        <div class="col-lg-8">
                            @if($product->single_ml)
                            <div class="subtitle">
                               <h4 style="display: none;">{{$product->single_ml}}</h4>
                            </div>
                            @endif
                        </div>
                    </div>

                    {{-- <div class="single_details_content d-flex pt-3">
                        <input type="hidden" name="base_sku_price" id="base_sku_price" value="
                        @if(@$product->hasDeal)
                            {{ selling_price($product->skus->first()->selling_price,$product->hasDeal->discount_type,$product->hasDeal->discount) }}
                        @else
                            @if($product->hasDiscount == 'yes')
                            {{selling_price(@$product->skus->first()->selling_price,@$product->discount_type,@$product->discount)}}

                            @else
                                {{@$product->skus->first()->selling_price}}
                            @endif
                        @endif
                        ">
                        <input type="hidden" name="final_price" id="final_price" value="
                        @if(@$product->hasDeal)
                            {{ selling_price($product->skus->first()->selling_price,$product->hasDeal->discount_type,$product->hasDeal->discount) }}
                        @else
                            @if($product->hasDiscount == 'yes')
                            {{selling_price(@$product->skus->first()->selling_price,@$product->discount_type,@$product->discount)}}

                            @else
                                {{@$product->skus->first()->selling_price}}
                            @endif
                        @endif
                        ">
                        <h5 class="mb-0">{{__('common.total')}} : </h5>
                        <h5 id="total_price">
                            @if(@$product->hasDeal)
                               ₹ {{(selling_price(@$product->skus->first()->selling_price,@$product->hasDeal->discount_type,@$product->hasDeal->discount) * $product->product->minimum_order_qty)}}
                            @else
                                @if($product->hasDiscount == 'yes')
                                   ₹ {{(selling_price(@$product->skus->first()->selling_price,@$product->discount_type,@$product->discount) * $product->product->minimum_order_qty)}}
                                @else
                                   ₹ {{(@$product->skus->first()->selling_price * $product->product->minimum_order_qty)}}
                                @endif
                            @endif
                        </h5>
                    </div> --}}

                    <div class="row wishlit_new_btn1">
                        <div class="col-lg-5 col-sm-5 col-md-5">
                            <span id="add_to_cart_div">
                                @if ($product->stock_manage == 1 && $product->skus->first()->product_stock >= $product->product->minimum_order_qty)
                
                                    <a href="#" type="button" id="add_to_cart_btn" class="btn btn-link btn-cart mt-3 "> <i class="fa fa-shopping-cart" aria-hidden="true"></i>
                                    {{__('defaultTheme.add_to_cart')}}</a>
                                @elseif($product->stock_manage == 0)
                                    <a href="#" type="button" id="add_to_cart_btn" class="btn btn-link btn-blck-bg mt-3"> <i class="fa fa-shopping-cart" aria-hidden="true"></i>
                                    {{__('defaultTheme.add_to_cart')}}</a>
                               @else
                                    <button type="button" disabled class="btn btn-link btn-blck-bg mt-3">{{__('defaultTheme.out_of_stock')}}</button>
                                @endif
                            </span>
                        </div>
                        {{-- <div class="col-lg-6 col-sm-6 col-md-6">
                            <a class="btn btn-link btn-wishtlist mt-3" id="wishlist_btn" data-product_id="{{$product->id}}" data-seller_id="{{$product->user_id}}"> <i class="fa fa-heart-o" aria-hidden="true"></i>
                                {{__('defaultTheme.add_to_wishlist')}}aaaaaaa</a>
                        </div> --}}
                        <div class='col-lg-5'>
                            <a class="btn btn-link btn-wishtlist mt-3 " id="wishlist_btn" data-product_id="{{$product->id}}" data-seller_id="{{$product->user_id}}"> <i class="fa fa-heart-o" aria-hidden="true"></i>
                        {{__('defaultTheme.add_to_wishlist')}}</a>
                        </div>
                    </div>

            {{-- <div class="btn-areaa ">
            <span id="add_to_cart_div">
                @if ($product->stock_manage == 1 && $product->skus->first()->product_stock >= $product->product->minimum_order_qty)

                    <a href="#" type="button" id="add_to_cart_btn" class="btn btn-link btn-blck-bg mt-3 ">{{__('defaultTheme.add_to_cart')}}</a>
                @elseif($product->stock_manage == 0)
                    <a href="#" type="button" id="add_to_cart_btn" class="btn btn-link btn-blck-bg mt-3">{{__('defaultTheme.add_to_cart')}}</a>
               @else
                    <button type="button" disabled class="btn btn-link btn-blck-bg mt-3">{{__('defaultTheme.out_of_stock')}}</button>
                @endif
            </span>
              <a class="btn btn-link btn-blck-bg mt-3 add_to_wishlist" id="wishlist_btn" data-product_id="{{$product->id}}" data-seller_id="{{$product->user_id}}">{{__('defaultTheme.add_to_wishlist')}}</a>
            </div> --}}
            @endif
          </div>
          <div class="row">
            <div class="col-lg-10">
                <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                    <li class="nav-item">
                      <a class="nav-link active" id="Description-tab" data-toggle="tab" href="#Description" role="tab" aria-controls="Description" aria-selected="true"> Product Details</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" id="Specifications-tab" data-toggle="tab" href="#specifications" role="tab" aria-controls="Specifications" aria-selected="false">FAQ's</a>
                    </li>
                  </ul>
                  <div class="tab-content" id="fade show active">
                    <div class="tab-pane fade active show" id="Description" role="tabpanel" aria-labelledby="Description-tab">
                      <span>
                       @php
                          echo $product->product->description;
                      @endphp
                    </span>
                     </div>
                    <div class="tab-pane fade" id="specifications" role="tabpanel" aria-labelledby="Specifications-tab">
                      <span>
                      @php
                          echo $product->product->specification;
                      @endphp
                      </span>
                    </div>
                  </div>
            </div>
          </div>
        
        <div class="row mt-3">
            <div class="col-sm-10">
                <form method="POST">
                    @csrf
                    <div class="input-group pininput mb-3">
                        <input type="text" id="pincode" name="pincode" class="form-control" maxlength="6" placeholder="Enter Your Pincode">
                    <div class="input-group-append">
                        <button style="background-color:#ba933e; border-color: #ba933e" id="submit" class="btn btn-success" type="submit">Check Availability</button>
                    </div>
                    </div>
                </form>
                <span id="successMsg" style="padding-bottom: 8px;color:red;font-size: 15px;"></span>
                <span id="reviewError" style="padding-bottom: 8px;color:green;font-size: 15px;"></span>
            </div>
        </div>
        </div>
      </div>
    </div>
  </div>
</div>
<div class='review_section mt-5' id='review_area'>
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class='review_heading border-bottom'>
                    <h3> Customer Reviews</h3>
                </div>
            </div>
        </div>
        <div class='row pb-4 border-bottom mt-4'>
            <div class="col-lg-4 border-dotted">
                <div class="average_rating">
                    <div class="boxreating">
                        <span class='box_rating4_average'>{{$show_total ?? "0"}}</span>
                        <span class='box_rating'>/5</span>
                    </div>
                    {{-- <div class='main_review_stars '>
                        <span><i class="fa fa-star" aria-hidden="true"></i></span>
                        <span><i class="fa fa-star" aria-hidden="true"></i></span>
                        <span><i class="fa fa-star" aria-hidden="true"></i></span>
                        <span><i class="fa fa-star" aria-hidden="true"></i></span>
                        <span><i class="fa fa-star" aria-hidden="true"></i></span>
                    </div> --}}
                    <p>From {{$productTotalReviews}} reviews</p>
                </div>
            </div>
            <div class="col-lg-4 border-dotted">
            <div class="review_rate_section">
    <div class="box_style2_rating" style="color: #000000;">
        <div class="grid-x areviews_rating_filter">
            <div class="large-2 medium-2 small-2 cell">5&nbsp; 
                <i style="color: #9c9c9c;" class="fas fa-star" aria-hidden="true"></i>
            </div>
            <div class='w-8'>
                <div class="prosserbar">
                    <div class="progress-bars" style="width:{{$rate_five ?? ""}}%"></div>
                </div> 
            </div>
            <div class="total_reviews_number_Rating">
                <span class="box_rating_number">{{($reviewNumber5)}}</span>
            </div>
        </div>
            <div class="grid-x areviews_rating_filter" data-rating="4" style="margin-top: 3px;">
                <div class="large-2 medium-2 small-2 cell">4&nbsp; <i style="color: #9c9c9c;" class="fas fa-star" aria-hidden="true"></i></div>
                <div class='w-8'><div class="prosserbar "><div class="progress-bars" style="width:{{$rate_four ?? ""}}%"></div></div> </div>
                <div class="total_reviews_number_Rating"><span class="box_rating_number">{{($reviewNumber4)}}</span></div>
            </div>

            <div class="grid-x areviews_rating_filter" data-rating="3" style="margin-top: 3px;">
                <div class="large-2 medium-2 small-2 cell">3&nbsp; <i style="color: #9c9c9c;" class="fas fa-star" aria-hidden="true"></i></div>
                <div class='w-8'>    <div class="prosserbar "><div class="progress-bars" style="width:{{$rate_three ?? ""}}%"></div></div> </div>
                <div class="total_reviews_number_Rating"><span class="box_rating_number">{{($reviewNumber3)}}</span></div>
            </div>
            <div class="grid-x areviews_rating_filter" data-rating="2" style="margin-top: 3px;">
                <div class="large-2 medium-2 small-2 cell">2&nbsp; <i style="color: #9c9c9c;" class="fas fa-star" aria-hidden="true"></i></div>
                <div class='w-8'>    <div class="prosserbar"><div class="progress-bars" style="width:{{$rate_two ?? ""}}%"></div></div> </div>
                <div class="total_reviews_number_Rating"><span class="box_rating_number">{{($reviewNumber2)}}</span></div>
            </div>
            <div class="grid-x areviews_rating_filter" data-rating="1" style="margin-top: 3px;">
                <div class="large-2 medium-2 small-2 cell">1&nbsp; <i style="color: #9c9c9c;" class="fas fa-star" aria-hidden="true"></i></div>
                <div class='w-8'>    <div class="prosserbar"><div class="progress-bars" style="width:{{$rate_one ?? ""}}%"></div></div> </div>
                <div class="total_reviews_number_Rating"><span class="box_rating_number">{{($reviewNumber1)}}</span></div>
            </div>
        </div>
    </div>
            </div>
            <div class="col-lg-4 border-dotted d-flex align-items-center justify-content-center">
                <a class='review_section_btn'>Write a Review</a>
            </div>
        </div>
        <div class='row mt-4'>
            <div class='col-lg-12'>
                <span id="reviewSuccessMsg" style="font-size:20px; text-align: center; color:green;"></span>
                <form name="data-form" id="dataForm" method="POST" enctype="multipart/form-data">
                    {{ csrf_field() }}
                <div class='from_reviews'>
                    <span id="reviewSuccess" style="font-size:20px; text-align: center; color:green;"></span>
                    <div class='form-group'>
                        <label>Name</label>
                        <input type="text" name="name" id="name" class='form-control' placeholder='Your Name'>
                    </div>
                    <div class='form-group'>
                        <label>Email</label>
                        <input type="email" name="email" id="email" class='form-control' placeholder='Your Email'>
                    </div>
                    <div class='reviewstart form-group mt-2'>
                    <h5>Your rating</h5>
                        <ul class="ratingW">
                        <li class="on"><a href="javascript:void(0);"><div class="star"></div></a></li>
                        <li class="on"><a href="javascript:void(0);"><div class="star"></div></a></li>
                        <li class="on"><a href="javascript:void(0);"><div class="star"></div></a></li>
                        <li><a href="javascript:void(0);"><div class="star"></div></a></li>
                        <li><a href="javascript:void(0);"><div class="star"></div></a></li>
                        </ul>
                        <p class="counterW">score: <span class="scoreNow">3</span> out of <span>5</span></p>
                    </div>
                    <div class='form-group'>
                        <label>Choose Image</label>
                        <input type="file" name="image" id="image" class='form-control'>
                    </div>
                    <input type="hidden" id="product_id" name="product_id" value="{{ $product->id }}">
                    <input type="hidden" id="rating" name="rating" value="" />
                    <input type="hidden" id="_token" name="_token" value="{{ csrf_token() }}" />
                    <div class='form-group'>
                        <textarea name="message" id="message" cols="10" rows="5" class='form-control' placeholder='Enter your comment'></textarea>
                    </div>
                    <button class='btn btn-success btn-submit' id="submitReview">Send Review</button>
                </div>
                </form>
            </div>
        </div>
    </div>
</div>
<div class='slider_reviews'>
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
            <div class="show-reviews owl-carousel owl-theme">
                @foreach($productReviews as $productReview)
                <div class="item">
                    <div class='slider_review_card'>
                        <div class='username'>
                            <h3>{{$productReview->name}}</h3>
                            <div class='reting_reviws'>
                                @for($i=1; $i<=$productReview->rating; $i++)
                                <span><i class='fa fa-star'></i></span>
                                @endfor
                            </div>
                            <p>{{$productReview->message}}</p>
                            <div class='reviewproduct_img'>
                                <img src="{{asset('uploads/reviewProduct/'.$productReview->image)}}" alt="" class="img-fluid">
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            </div>
        </div>
    </div>
</div>

                   <div class="single_details_content d-flex">
                        <input type="hidden" name="base_sku_price" id="base_sku_price" value="
                        @if(Auth::user()  &&  Auth::user()->is_membership  && ($product->skus->first()->vip_status == 1))
                            {{(selling_price(@$product->skus->first()->vip_member_price ))}}
                        @else
                          @if(@$product->hasDeal)
                            {{ selling_price($product->skus->first()->selling_price,$product->hasDeal->discount_type,$product->hasDeal->discount) }}
                        @else
                            @if($product->hasDiscount == 'yes')
                            {{selling_price(@$product->skus->first()->selling_price,@$product->discount_type,@$product->discount)}}

                            @else
                                {{@$product->skus->first()->selling_price}}
                            @endif
                        @endif
                        @endif
                        ">
                        <input type="hidden" name="final_price" id="final_price" value="
                        @if(@$product->hasDeal)
                            {{ selling_price($product->skus->first()->selling_price,$product->hasDeal->discount_type,$product->hasDeal->discount) }}
                        @else
                            @if($product->hasDiscount == 'yes')
                            {{selling_price(@$product->skus->first()->selling_price,@$product->discount_type,@$product->discount)}}

                            @else
                                {{@$product->skus->first()->selling_price}}
                            @endif
                        @endif
                        ">
                    </div>
            {{-- {{dd($product->stock_manage)}} --}}
                    <input type="hidden" name="product_sku_id" id="product_sku_id" value="{{$product->product->product_type == 1?$product->skus->first()->id : $product->skus->first()->id}}">
                    <input type="hidden" name="seller_id" id="seller_id" value="{{$product->user_id}}">
                    <input type="hidden" name="seller_id" id="seller_id" value="{{$product->user_id}}">
                    <input type="hidden" name="seller_id" id="seller_id" value="{{$product->user_id}}">
                    <input type="hidden" name="stock_manage_status" id="stock_manage_status" value="{{$product->stock_manage}}">
                    <input type="hidden" name="qty" class="qty" id="qty" value="{{$product->product->minimum_order_qty}}"/>
                    <input type="hidden" id="product_id" name="product_id" value="{{ $product->id }}">
                    <input type="hidden" id="login_check" value="@if(auth()->check()) 1 @else 0 @endif">



<!-- product New-details end -->

{{-- @if ($product->related_sales->count() > 0)
    <!-- related product here -->
    <section class="related_product padding_top">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="section_tittle">
                        <h4>{{__('defaultTheme.related_products')}}</h4>
                    </div>
                </div>
                @foreach ($product->related_sales as $key => $related_sale)
                    @foreach ($related_sale->related_seller_products->take(2) as $key => $related_seller_product)
                        <div class="col-lg-4 col-sm-6">
                            <div class="single_related_product media_style">
                                <div class="single_product_img">
                                    <img src="
                                        @if($related_seller_product->thum_img)
                                            {{showImage(@$related_seller_product->thum_img)}}
                                        @else
                                            {{showImage(@$related_seller_product->product->thumbnail_image_source)}}
                                        @endif
                                    " alt="#" class="img-fluid var_img_show" />
                                    <a href="{{singleProductURL($related_seller_product->seller->slug, $related_seller_product->slug)}}" target="_blank"><i class="ti-bag"></i></a>
                                </div>
                                <div class="single_product_text align-self-center related_product_width">
                                    <a href="{{singleProductURL($related_seller_product->seller->slug, $related_seller_product->slug)}}" target="_blank">{{ @$related_seller_product->product_name?@$related_seller_product->product_name:@$related_seller_product->product->product_name }}</a>
                                    <div class="category_product_price">
                                        <h4>
                                            @if(@$related_seller_product->hasDeal)
                                                @if (@$related_seller_product->product->product_type == 1)
                                                    {{single_price(selling_price(@$related_seller_product->skus->first()->selling_price,@$related_seller_product->hasDeal->discount_type,@$related_seller_product->hasDeal->discount))}}
                                                @else
                                                    @if (selling_price(@$related_seller_product->skus->min('selling_price'),@$related_seller_product->hasDeal->discount_type,@$related_seller_product->hasDeal->discount) === selling_price(@$related_seller_product->skus->max('selling_price'),@$related_seller_product->hasDeal->discount_type,@$related_seller_product->hasDeal->discount))
                                                        {{single_price(selling_price(@$related_seller_product->skus->min('selling_price'),@$related_seller_product->hasDeal->discount_type,@$related_seller_product->hasDeal->discount))}}
                                                    @else
                                                        {{single_price(selling_price(@$related_seller_product->skus->min('selling_price'),@$related_seller_product->hasDeal->discount_type,@$related_seller_product->hasDeal->discount))}} - {{single_price(selling_price(@$related_seller_product->skus->max('selling_price'),@$related_seller_product->hasDeal->discount_type,@$related_seller_product->hasDeal->discount))}}
                                                    @endif
                                                @endif
                                            @else

                                                @if ($related_seller_product->product->product_type == 1)
                                                    @if(@$related_seller_product->hasDiscount == 'yes')
                                                        {{single_price(selling_price(@$related_seller_product->skus->first()->selling_price,@$related_seller_product->discount_type,@$related_seller_product->discount))}}
                                                    @else
                                                        {{single_price(@$related_seller_product->skus->first()->selling_price)}}
                                                    @endif
                                                @else
                                                    @if(@$related_seller_product->hasDiscount == 'yes')
                                                        @if (selling_price(@$related_seller_product->skus->min('selling_price'),$related_seller_product->discount_type,$related_seller_product->discount) === selling_price(@$related_seller_product->skus->max('selling_price'),$related_seller_product->discount_type,$related_seller_product->discount))
                                                            {{single_price(selling_price(@$up_seller_product->skus->min('selling_price'),$up_seller_product->discount_type,$up_seller_product->discount))}}
                                                        @else
                                                            {{single_price(selling_price(@$related_seller_product->skus->min('selling_price'),$related_seller_product->discount_type,$related_seller_product->discount))}} - {{single_price(selling_price(@$related_seller_product->skus->max('selling_price'),$related_seller_product->discount_type,$related_seller_product->discount))}}
                                                        @endif
                                                    @else
                                                        @if(@$related_seller_product->skus->min('selling_price') === @$related_seller_product->skus->max('selling_price'))
                                                            {{single_price(@$related_seller_product->skus->min('selling_price'))}}
                                                        @else
                                                            {{single_price(@$related_seller_product->skus->min('selling_price'))}} - {{single_price(@$related_seller_product->skus->max('selling_price'))}}
                                                        @endif
                                                    @endif
                                                @endif
                                            @endif
                                        </h4>

                                        <a href="" class="wishlist_btn_for_site add_to_wishlist {{@$related_seller_product->is_wishlist() == 1?'is_wishlist':''}}" id="wishlistbtn_{{$related_seller_product->id}}" data-product_id="{{$related_seller_product->id}}" data-seller_id="{{$related_seller_product->user_id}}"><i class="ti-heart"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endforeach

            </div>
        </div>
    </section>
    <!-- related product end -->
@endif --}}
@endsection



@push('scripts')
    <!-- <script src="{{ asset(asset_path('frontend/default/js/zoom.js')) }}"></script> -->
    <script>

        (function($){
            "use strict";

               $(document).on('click', '#add_to_cart_btn_variation', function(event){
                    event.preventDefault();
                    let selected_option =  $('#add_to_cart_btn_select option:selected');
                    console.log(selected_option)
                    let  product_sku_id = selected_option.attr('product_sku_id')
                    let qty = 1;
                    let price = selected_option.attr('base_sku_price');
                    addToCart(product_sku_id,$('#seller_id').val(),1,price,$('#shipping_type').val(),'product');

                });

               $(document).on('change', '#add_to_cart_btn_select', function(event){
                    event.preventDefault();
                    console.log($(this).val())
                    let selected_price =  $('#add_to_cart_btn_select option:selected');
                    let price = selected_price.attr('base_sku_price');
                    let image = selected_price.attr('image');
                    let variant_id= selected_price.attr('variant-id');
                    console.log(image,variant_id,"variant_idvariant_idvariant_id")
                    if(image && variant_id){
                    	$('.gallary_img').removeClass('active show')
                    	$('#thumb_'+variant_id).addClass('active show')
                    }
                    $('#varient_price').html(price);
                    console.log(price,"asdfasdf asdfg");
               });
               

                $(document).on('click', '#add_to_cart_btn', function(event){
                    addToCart($('#product_sku_id').val(),$('#seller_id').val(),$('#qty').val(),$('#base_sku_price').val(),$('#shipping_type').val(),'product');
                });

                $(document).on('click', '.add_to_wishlist', function(event){
                    event.preventDefault();
                    let product_id = $(this).data('product_id');
                    let seller_id = $(this).data('seller_id');
                    let is_login = $('#login_check').val();
                    let type = 'product';
                    if(is_login == 1){
                        addToWishlist(product_id,seller_id, type);
                        $(this).addClass('is_wishlist');
                    }else{
                        toastr.warning("{{__('defaultTheme.please_login_first')}}","{{__('common.warning')}}");
                    }
                });

                $(document).on('click', '#wishlist_btn', function(event){
                    event.preventDefault();
                    let product_id = $(this).data('product_id');
                    let seller_id = $(this).data('seller_id');
                    let type = "product";
                    let is_login = $('#login_check').val();
                    if(is_login == 1){
                        addToWishlist(product_id, seller_id, type);
                    }else{
                        toastr.warning("{{__('defaultTheme.please_login_first')}}","{{__('common.warning')}}");
                    }
                });
            
            $(document).ready(function(){
                $('#submit').on('click',function(e){
                e.preventDefault();
                let getPincode = $('#pincode').val();
                var data = getPincode ;

                $.ajax({
                    type:"POST",
                    url:"/check-pincode",
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    data:{"pincode":getPincode},      
                    success: function (response) {
                    
                    console.log(response.success , "success");
                    console.log(response.error , "error");
                    if(response.errorStatus == true){
                        $('#successMsg').html(response.success);
                        setTimeout(function() {
                        $('#successMsg').fadeOut('fast');
                        }, 3000);
                    }else{
                        $('#reviewError').html(response.success);
                        setTimeout(function() {
                        $('#reviewError').fadeOut('fast');
                        }, 3000);
                    }
                }
             });
            });
        });

            $(document).on('click', '#add_to_compare_btn', function(event){
                    event.preventDefault();
                    let product_sku_class = $(this).data('product_sku_id');
                    let product_sku_id = $(product_sku_class).val();
                    let product_type = $(this).data('product_type');
                    addToCompare(product_sku_id, product_type, 'product');
                });

                $(document).on('click', '.qtyChange', function(event){
                    event.preventDefault();
                    let value = $(this).data('value');
                    qtyChange(value);
                });

                function qtyChange(val){
                    $('.cart-qty-minus').prop('disabled',false);
                    let available_stock = $('#availability').html();
                    let stock_manage_status = $('#stock_manage_status').val();
                    let maximum_order_qty = $('#maximum_order_qty').val();
                    let minimum_order_qty = $('#minimum_order_qty').val();
                    let qty = $('#qty').val();
                    if (stock_manage_status != 0) {
                        if (parseInt(qty) < parseInt(available_stock)) {
                            if(val == '+'){
                                if(maximum_order_qty != ''){
                                    if(parseInt(qty) < parseInt(maximum_order_qty)){
                                    let qty1 = parseInt(++qty);
                                    $('#qty').val(qty1)
                                    totalValue(qty1, '#base_price','#total_price');
                                    }else{
                                        toastr.warning('{{__("defaultTheme.maximum_quantity_limit_is")}}'+maximum_order_qty+'.', '{{__("common.warning")}}');
                                    }
                                }else{
                                    let qty1 = parseInt(++qty);
                                    $('#qty').val(qty1)
                                    totalValue(qty1, '#base_price','#total_price');
                                }


                            }
                            if(val == '-'){
                                if(minimum_order_qty != ''){
                                    if(parseInt(qty) > parseInt(minimum_order_qty)){
                                        if(qty>1){
                                            let qty1 = parseInt(--qty);
                                            $('#qty').val(qty1)
                                            totalValue(qty1, '#base_price','#total_price')
                                            $('.cart-qty-minus').prop('disabled',false);
                                        }else{
                                            $('.cart-qty-minus').prop('disabled',true);
                                        }
                                    }else{
                                        toastr.warning('{{__("defaultTheme.minimum_quantity_Limit_is")}}'+minimum_order_qty+'.', '{{__("common.warning")}}')
                                    }
                                }else{
                                    if(parseInt(qty)>1){
                                        let qty1 = parseInt(--qty)
                                        $('#qty').val(qty1)
                                        totalValue(qty1, '#base_price','#total_price')
                                        $('.cart-qty-minus').prop('disabled',false);
                                    }else{
                                        $('.cart-qty-minus').prop('disabled',true);
                                    }
                                }
                            }
                        }else {
                            toastr.error("{{__('defaultTheme.no_more_stock')}}", "{{__('common.error')}}");
                        }
                    }
                    else {
                        if(val == '+'){
                            if(maximum_order_qty != ''){
                                if(parseInt(qty) < parseInt(maximum_order_qty)){
                                let qty1 = parseInt(++qty);
                                $('#qty').val(qty1)
                                totalValue(qty1, '#base_price','#total_price');
                                }else{
                                    toastr.warning('{{__("defaultTheme.maximum_quantity_limit_is")}}'+maximum_order_qty+'.', '{{__("common.warning")}}')
                                }
                            }else{
                                let qty1 = parseInt(++qty);
                                $('#qty').val(qty1)
                                totalValue(qty1, '#base_price','#total_price');
                            }


                        }
                        if(val == '-'){
                            if(minimum_order_qty != ''){
                                if(parseInt(qty) > parseInt(minimum_order_qty)){
                                    if(qty>1){
                                        let qty1 = parseInt(--qty)
                                        $('#qty').val(qty1)
                                        totalValue(qty1, '#base_price','#total_price')
                                        $('.cart-qty-minus').prop('disabled',false);
                                    }else{
                                        $('.cart-qty-minus').prop('disabled',true);
                                    }
                                }else{
                                    toastr.warning('{{__("defaultTheme.minimum_quantity_Limit_is")}}'+minimum_order_qty+'.', '{{__("common.warning")}}')
                                }
                            }else{
                                if(parseInt(qty)>1){
                                    let qty1 = parseInt(--qty)
                                    $('#qty').val(qty1)
                                    totalValue(qty1, '#base_price','#total_price')
                                    $('.cart-qty-minus').prop('disabled',false);
                                }else{
                                    $('.cart-qty-minus').prop('disabled',true);
                                }
                            }
                        }
                    }

                }


                $(document).on('click', '.change_qty', function(event){
                    let type = $(this).val();
                    let cahnge_qty = 1;
                    let qty_id = $(this).data("qty_id");
                    let maximum_qty = $(this).data("maximum_qty");
                    let minimum_qty = $(this).data("minimum_qty");
                    var stock_manage = $(this).attr("data-stock_manage");
                    var product_stock = $(this).attr("data-product_stock");
                    var old_qty = $(qty_id).val();
                    let max_qty = $(maximum_qty).val();
                    let min_qty = $(minimum_qty).val();
                    if(stock_manage != '0'){
                        if(type === '+'){
                            var pre_qty = parseInt(cahnge_qty) + parseInt(old_qty);
                            if(max_qty != ''){
                                if (parseInt(pre_qty) <= parseInt(product_stock)) {
                                    if(parseInt(pre_qty) <= parseInt(max_qty) ){
                                        console.log(pre_qty);
                                        $(qty_id).val(pre_qty);
                                    }else{
                                        toastr.warning("{{__('defaultTheme.maximum_quantity_limit_exceed')}}","{{__('common.warning')}}");
                                    }
                                }else{
                                    toastr.warning("{{__('defaultTheme.no_more_stock_available')}}","{{__('common.warning')}}");
                                }        
                            }else{
                                if (parseInt(pre_qty) < parseInt(product_stock)) {
                                    $(qty_id).val(pre_qty);
                                }else{
                                    toastr.warning("{{__('defaultTheme.no_more_stock_available')}}","{{__('common.warning')}}");
                                }
                            }
                        }else if(type === '-'){
                            var pre_qty = parseInt(old_qty) - parseInt(cahnge_qty);
                            if(min_qty != ''){
                                if(parseInt(pre_qty) >= parseInt(min_qty)){
                                    $(qty_id).val(pre_qty);
                                }else{
                                    toastr.warning("{{__('defaultTheme.minimum_quantity_limit_exceed')}}","{{__('common.warning')}}");
                                }
                            }else{
                                if(parseInt(pre_qty) > 1){
                                    $(qty_id).val(pre_qty);
                                }else{
                                    toastr.warning("{{__('defaultTheme.minimum_quantity_limit_exceed')}}","{{__('common.warning')}}");
                                }
                            }
                        }
                    }else{
                        if(type === '+'){
                            var pre_qty = parseInt(cahnge_qty) + parseInt(old_qty);
                            if(max_qty != ''){
                                if(parseInt(pre_qty) <= parseInt(max_qty) ){
                                    $(qty_id).val(pre_qty);
                                }else{
                                    toastr.warning("{{__('defaultTheme.maximum_quantity_limit_exceed')}}","{{__('common.warning')}}");
                                }
                            }else{
                                $(qty_id).val(pre_qty);
                            }
                        }else if(type === '-'){
                            var pre_qty = parseInt(old_qty) - parseInt(cahnge_qty);
                            if(min_qty != ''){
                                if(parseInt(pre_qty) >= parseInt(min_qty)){
                                    $(qty_id).val(pre_qty);
                                }else{
                                    toastr.warning("{{__('defaultTheme.minimum_quantity_limit_exceed')}}","{{__('common.warning')}}");
                                }
                            }else{
                                if(parseInt(pre_qty) > 1){
                                    $(qty_id).val(pre_qty);
                                }else{
                                    toastr.warning("{{__('defaultTheme.minimum_quantity_limit_exceed')}}","{{__('common.warning')}}");
                                }
                            }
                        }
                    }
                });

                function totalValue(qty, main_price, total_price){
                    let base_sku_price = $('#base_sku_price').val();
                    let value = parseInt(qty) * parseFloat(base_sku_price);
                    $(total_price).html(currency_format(value));
                    $('#final_price').val(value);
                }

            $(document).ready(function() {
            const minus = $('.quantity__minus');
            const plus = $('.quantity__plus');
            const input = $('.quantity__input');
            minus.click(function(e) {
            e.preventDefault();
           var value = input.val();
           if (value > 1) {
             value--;
            }
               input.val(value);
            });
  
            plus.click(function(e) {
            e.preventDefault();
            var value = input.val();
           value++;
           input.val(value);
           })
        });
       

            $(document).ready(function(){
                if($(".zoom_01").length > 0){
                    $(".zoom_01").elevateZoom({
                        scrollZoom : true
                    });
                }

                $(document).on('click', '.page-item a', function(event){
                    event.preventDefault();
                    let page = $(this).attr('href').split('page=')[1];

                    fetch_data(page);

                });

                function fetch_data(page){
                    $('#pre-loader').show();

                    var url = "{{route('frontend.product.reviews.get-data')}}" + '?product_id='+ "{{$product->id}}" +'&page=' + page;


                    if(page != 'undefined'){
                        $.ajax({
                            url: url,
                            success:function(data)
                            {
                                $('#Reviews').html(data);
                                $('#pre-loader').hide();
                            }
                        });
                    }else{
                        toastr.warning('this is undefined');
                    }

                }


                var productType = $('.product_type').val();
                if (productType == 2) {
                    '@if (session()->has('item_details'))'+
                        '@foreach (session()->get('item_details') as $key => $item)'+
                            '@if ($item['name'] === "Color")'+
                                '@foreach ($item['value'] as $k => $value_name)'+
                                    $(".colors_{{$k}}").css("background-color", "{{ $item['code'][$k]}}");
                                '@endforeach'+
                            '@endif'+
                        '@endforeach'+
                    '@endif'
                }


                $(document).on('click', '.attr_val_name', function(){

                    $(this).parent().parent().find('.attr_value_name').val($(this).attr('data-value')+'-'+$(this).attr('data-value-key'));
                    $(this).parent().parent().find('.attr_value_id').val($(this).attr('data-value')+'-'+$(this).attr('data-value-key'));

                    if ($(this).attr('color') == "color") {
                        $('.attr_clr').removeClass('selected_btn');
                    }
                    if ($(this).attr('color') == "not") {
                        $('.not_111').removeClass('selected_btn');
                    }
                    $(this).addClass('selected_btn');
                    get_price_accordint_to_sku();

                });

                var old_html = $("#myTabContent").html();
                $('.var_img_source').hover(function() {
                    
                    var logo = $(this).attr("src"); // get logo from data-icon parameter
                    $('.var_img_show').attr("src", logo); // change logo
                }, function() {
                    $("#myTabContent").html(old_html); // remove logo
                    if($(".zoom_01").length > 0){
                        $(".zoom_01").elevateZoom({
                            scrollZoom : true
                        });
                    }
                });


                function get_price_accordint_to_sku(){
                    var value = $("input[name='attr_val_name[]']").map(function(){return $(this).val();}).get();
                    var id = $("input[name='attr_val_id[]']").map(function(){return $(this).val();}).get();
                    var product_id = $("#product_id").val();
                    var user_id = $('#seller_id').val();
                    $('#pre-loader').show();
                    $.post('{{ route('seller.get_seller_product_sku_wise_price') }}', {_token:'{{ csrf_token() }}', id:id, product_id:product_id, user_id:user_id}, function(response){
                        if (response != 0) {
                            let discount_type = $('#discount_type').val();
                            let discount = $('#discount').val();
                            let qty = $('.qty').val();

                            calculatePrice(response.data.selling_price, discount, discount_type, qty);
                            $('#sku_id_li').text(response.data.sku.sku);
                            $('#product_sku_id').val(response.data.id);

                            $('#availability').html(response.data.product_stock);
                            if(parseInt(response.data.product_stock) >= parseInt(response.data.product.product.minimum_order_qty)){
                                $('#add_to_cart_div').html(`
                                    <button type="button" id="add_to_cart_btn" class="btn_1">{{__('defaultTheme.add_to_cart')}}</button>
                                `);
                            }
                            else if(response.data.product.stock_manage == 0){
                                $('#add_to_cart_div').html(`
                                    <button type="button" id="add_to_cart_btn" class="btn_1">{{__('defaultTheme.add_to_cart')}}</button>
                                `);
                            }

                            else{
                                $('#add_to_cart_div').html(`
                                    <button type="button" disabled class="btn_1">{{__('defaultTheme.out_of_stock')}}</button>
                                `);
                                toastr.warning("{{__('defaultTheme.out_of_stock')}}");
                            }
                        }else {
                            toastr.error("{{__('defaultTheme.no_stock_found_for_this_seller')}}", "{{__('common.error')}}");
                        }
                        $('#pre-loader').hide();
                    });
                }

                function calculatePrice(main_price, discount, discount_type, qty){
                    var main_price = main_price;
                    var discount = discount;
                    var discount_type = discount_type;
                    var total_price = 0;
                    if (discount_type == 0) {
                        discount = (main_price * discount) / 100;
                    }
                    total_price = (main_price - discount);

                    $('#total_price').html(currency_format((total_price * qty)));
                    $('#base_sku_price').val(total_price);
                    $('#final_price').val(total_price);
                }
            });
        })(jQuery);
    </script>

    <script>
    function ratingStar(star){
    star.click(function(){
        var stars = $('.ratingW').find('li')
        stars.removeClass('on');
        var thisIndex = $(this).parents('li').index();
        for(var i=0; i <= thisIndex; i++){
            stars.eq(i).addClass('on');
        }
        putScoreNow(thisIndex+1);
    });
    }

    function putScoreNow(i){
        // console.log(i,"score")
        $('.scoreNow').html(i);
        $('#rating').val(i);
    }


    $(function(){
        if($('.ratingW').length > 0){
            ratingStar($('.ratingW li a'));
        }
    });
    </script>

    <script>
        $(".review_section_btn").click(function(){
        $(".from_reviews").toggle(400);
    });
    </script>

    <script>
        $(document).ready(function(){
            $('#submitReview').on('click', (e) => {
            e.preventDefault();
            $.ajax({
                type:"POST",
                url:"/review",
                dataType: 'json',
                cache : false,
                processData: false,
                contentType: false,
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                data : new FormData($('#dataForm')[0]),      
                success: function (response){
                if(response.status == "true")
                $('#reviewSuccessMsg').html(response.success);
                else
                $('#reviewSuccessMsg').html(response.success);
                console.log(response);
                }
             });
            });
        });
</script>

@endpush





