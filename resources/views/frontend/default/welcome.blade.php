@extends('frontend.default.layouts.app')
@section('styles')
<link rel="stylesheet" href="{{asset(asset_path('frontend/default/css/page_css/welcome.css'))}}" />
@endsection
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.4.24/dist/sweetalert2.all.min.js"  referrerpolicy="no-referrer"></script>
@section('share_meta')
  @php
    $tags = str_replace(',', ' ',app('general_setting')->meta_tags);
  @endphp

  @php
    $offerCollection = \Modules\Appearance\Entities\OfferCollection::get();
  @endphp

  <meta name="keywords" content="{{$tags}}">
  <meta name="description" content="{{app('general_setting')->meta_description}}">
  <link rel="canonical" href="{{url()->current()}}"/>
@endsection
@section('content')
@include('frontend.default.partials._mega_menu')
@if(session('success'))
  <script type="text/javascript">
    Swal.fire({
      icon: 'success',
      title: 'Thank you for your enquiry, we will get back !!',
      timer: 5000,
    });
  </script>
  @endif
  @if(session('error'))
    <script type="text/javascript">
     Swal.fire({
      icon: 'error',
      title: 'Something Went Wrong',
      timer: 5000,
    });
    </script>
  @endif
{{-- <div id="wrapper">
    <div class="slider-wrapper theme-default">
      <div id="slider" class="nivoSlider">
          <img src="{{asset('frontend/default/img/slider1.png')}}" data-thumb="{{asset('frontend/default/img/slider1.png')}}" alt="" title="#htmlcaption"/> 

          <img src="{{asset('frontend/default/img/slider2.png')}}" data-thumb="{{asset('frontend/default/img/slider2.png')}}" alt="" title="#htmlcaption" />

          <img src="{{asset('frontend/default/img/slider3.png')}}" data-thumb="{{asset('frontend/default/img/slider3.png')}}" alt="" data-transition="slideInLeft"  title="#htmlcaption" /> 

           <img src="{{asset('frontend/default/img/slider1.png')}}" data-thumb="{{asset('frontend/default/img/slider1.png')}}" alt=""  title="#htmlcaption"/> 

      </div>
      <div id="htmlcaption" class="nivo-html-caption w3-animate-top"> 
         <p class="animate__fadeInLeft">Quick parcel delivery, <span> from $25 </span></p>
         <h3 class="fadeInRight">Wood Minimal  Office Chair  <br>Extra 40% off now.</h3>
        <div class="fadeInBottom"> <a href="{{route('frontend.product')}}" class="btn btn-link btn-clik ">Start Shoping</a></div>
      </div>
     <!--   <div id="slidercaption" class="nivo-html-caption"> 
          <h3>Best Perfume and selles Product</h3> 
      </div> -->
    </div>
</div> --}}
<div class="container-fluid">
  <div class="row">
    <div class="col-lg-6">
      <div class="row">
        <div class="col-lg-6">
          <div class="banner-content effect-2">
            <a href="{{$offerCollection[0]->data_type}}"><img src="{{$offerCollection[0]->offer_image}}" alt=""></a>
              <div class="text">
              <h2 >{{$offerCollection[0]->name}}</h2>
              <p>{!! $offerCollection[0]->description !!}</p>
              </div>
            </div>
        </div>
        <div class="col-lg-6">
           <div class="banner-content effect-2">
            <a href="{{$offerCollection[1]->data_type}}"><img src="{{$offerCollection[1]->offer_image}}" alt=""></a>
              <div class="text">
              <h2 class="text-white">{{$offerCollection[1]->name}}</h2>
              <p class="text-white">{!! $offerCollection[1]->description !!}</p>
              </div>
            </div>
        </div>
      </div>
    </div>
    <div class="col-lg-6">
      <div class="banner-content effect-2">
          <a href="{{$offerCollection[2]->data_type}}"><img src="{{$offerCollection[2]->offer_image}}" alt=""></a>
            <div class="text">
            <h2>{{$offerCollection[2]->name}}</h2>
            <p>{!! $offerCollection[2]->description !!}</p></div>
        </div>
    </div>
  </div>
</div>


<div class="arivalproduct new_product pt-50 pb-50">
  <div class="container-fluid">
    <div class="row">
      <div class="col-lg-12 text-center mb-5">
          <h2>New Arrivals</h2>
          <p>Claritas est etiam processus dynamicus, qui sequitur.</p>
      </div>
    </div>
    <div class="row">
      {{-- <div class="col-lg-6">
        <a href="#" class="effect-1">
          <img src="{{asset('frontend/default/img/arrval-img11.jpg')}}" alt="" class="img-fluid">
        </a>
      </div> --}}
@php
  $best_deal = $widgets->where('section_name','best_deals')->first();
@endphp
      <div class="col-lg-12">
        <div class="row product_block">
          <div class="col-lg-12">
            <div class="product_item owl-carousel owl-theme row">
             
              @foreach($best_deal->getProductByQuery() as $key => $product)
              <div class="item">
                <div class="product_box_cart">
                  <div class="img_caption">
                    <div class="produt_img">
                      <a href="{{singleProductURL($product->seller->slug, $product->slug)}}">
                        <img  @if ($product->thum_img != null) data-src="{{showImage($product->thum_img)}}" @else data-src="{{showImage(@$product->product->thumbnail_image_source)}}" @endif alt="{{@$product->product->product_name}}" src="{{showImage(@$product->product->thumbnail_image_source)}}" class="img-fluid lazyload pic-1">
                      </a>
                    </div>
                    <div class="action_inner">
                      <ul>
                        <li><a href="" class="add_to_wishlists {{$product->is_wishlist() == 1?'is_wishlist':''}}" id="wishlistbtn_{{$product->id}}" data-product_id="{{$product->id}}" data-seller_id="{{$product->user_id}}" data-tip=" Wishlist"><i class="bi bi-heart"></i></a></li>
                          {{-- <li><a href="#"><i class="bi bi-eye"></i></a></li> --}}
                      </ul>
                    </div>
                    <div class="produt_btnclik">
                      <a href="" data-tip="add to cart" class="addToCartFromThumnail btn btn-link cart-bnt" data-producttype="{{ @$product->product->product_type }}" data-seller={{ $product->user_id }} data-product-sku={{ @$product->skus->first()->id }}
                              @if(Auth::user() && Auth::user()->is_membership  && ($product->skus->first()->vip_status == 1))
                                  data-base-price={{(selling_price(@$product->skus->first()->vip_member_price ))}}
                              @elseif(@$product->hasDeal)
                                data-base-price={{ selling_price(@$product->skus->first()->selling_price,@$product->hasDeal->discount_type,@$product->hasDeal->discount) }}
                              @else
                                  @if($product->hasDiscount == 'yes')
                                  data-base-price={{ selling_price(@$product->skus->first()->selling_price,@$product->discount_type,@$product->discount) }}
                                  @else
                                  data-base-price={{ @$product->skus->first()->selling_price }}
                                  @endif

                                @endif
                                data-shipping-method=0
                                data-product-id="{{ $product->id }}"
                                data-stock_manage="{{$product->stock_manage}}"
                                data-stock="{{@$product->skus->first()->product_stock}}"
                                data-min_qty="{{$product->product->minimum_order_qty}}"><i class="bi bi-cart"></i> Add To Cart</a>
                      </div>
                    </div>
                    <input type="hidden" id="login_check" value="@if(auth()->check()) 1 @else 0 @endif">
              <div class="product_info">
                <strong class="produt_name">@if($product->product_name != null) {{ \Illuminate\Support\Str::limit(@$product->product_name, 20, $end='...') }} @else {{ \Illuminate\Support\Str::limit(@$product->product->product_name, 15, $end='...') }} @endif</strong>
                <div class="prod_summery">
                  <div class="price">
                        @if(Auth::user()  &&  Auth::user()->is_membership  && ($product->skus->first()->vip_status == 1))
                            {{-- @if($product->hasDeal)
                               ₹ {{(selling_price($product->skus->first()->vip_member_price,$product->hasDeal->discount_type,$product->hasDeal->discount))}}
                            @else
                                @if($product->hasDiscount == 'yes')
                                   ₹ {{(selling_price(@$product->skus->first()->vip_member_price,@$product->discount_type,@$product->discount))}}
                                @else
                                   ₹ {{(@$product->skus->first()->vip_member_price)}}
                                @endif
                            @endif --}}
                            <span class="">₹ {{(selling_price(@$product->skus->first()->vip_member_price ))}}
                            </span>
                        @else
                            @if($product->hasDeal)
                               ₹ {{(selling_price($product->skus->first()->selling_price,$product->hasDeal->discount_type,$product->hasDeal->discount))}}
                            @else
                                @if($product->hasDiscount == 'yes')
                                   ₹ {{(selling_price(@$product->skus->first()->selling_price,@$product->discount_type,@$product->discount))}}

                                @else
                                   ₹ {{(@$product->skus->first()->selling_price)}}
                                @endif
                            @endif<span class="cutprice">₹ {{(selling_price(@$product->skus->first()->selling_price ))}}
                            </span>
                        @endif
                  </div>
                </div>
              </div>
              </div>
                <!-- 2nd Product -->

         {{--        <div class="product_box_cart">
                  <div class="img_caption">
                    <div class="produt_img">
                      <a href="{{singleProductURL($product->seller->slug, $product->slug)}}">
                        <img  @if ($product->thum_img != null) data-src="{{showImage($product->thum_img)}}" @else data-src="{{showImage(@$product->product->thumbnail_image_source)}}" @endif alt="{{@$product->product->product_name}}" src="{{showImage(@$product->product->thumbnail_image_source)}}" class="img-fluid lazyload pic-1">
                    </a>
                       </div>
                      <div class="action_inner">
                        <ul>
                          <li><a href="" class="add_to_wishlists {{$product->is_wishlist() == 1?'is_wishlist':''}}" id="wishlistbtn_{{$product->id}}" data-product_id="{{$product->id}}" data-seller_id="{{$product->user_id}}" data-tip=" Wishlist"><i class="bi bi-heart"></i></a></li>
                          {{-- <li><a href="#"><i class="bi bi-eye"></i></a></li> 
                        </ul>
                        <input type="hidden" id="login_check" value="@if(auth()->check()) 1 @else 0 @endif">
                      </div>
                      <div class="produt_btnclik">
                       <a href="" data-tip="add to cart" class="addToCartFromThumnail btn btn-link cart-bnt" data-producttype="{{ @$product->product->product_type }}" data-seller={{ $product->user_id }} data-product-sku={{ @$product->skus->first()->id }}
                                @if(Auth::user() && Auth::user()->is_membership  && ($product->skus->first()->vip_status == 1))
                                  data-base-price={{(selling_price(@$product->skus->first()->vip_member_price ))}}
                                @elseif(@$product->hasDeal)
                                data-base-price={{ selling_price(@$product->skus->first()->selling_price,@$product->hasDeal->discount_type,@$product->hasDeal->discount) }}
                                @else
                                  @if($product->hasDiscount == 'yes')
                                  data-base-price={{ selling_price(@$product->skus->first()->selling_price,@$product->discount_type,@$product->discount) }}
                                  @else
                                  data-base-price={{ @$product->skus->first()->selling_price }}
                                  @endif

                                @endif
                                data-shipping-method=0
                                data-product-id="{{ $product->id }}"
                                data-stock_manage="{{$product->stock_manage}}"
                                data-stock="{{@$product->skus->first()->product_stock}}"
                                data-min_qty="{{$product->product->minimum_order_qty}}"><i class="bi bi-cart"></i> Add To Cart</a>
                      </div>
                    </div>
                    <div class="product_info">
                <strong class="produt_name">@if($product->product_name != null) {{ \Illuminate\Support\Str::limit(@$product->product_name, 20, $end='...') }} @else {{ \Illuminate\Support\Str::limit(@$product->product->product_name, 15, $end='...') }} @endif</strong>
                <div class="prod_summery">
                  <div class="price">
                        @if(Auth::user()  &&  Auth::user()->is_membership  && ($product->skus->first()->vip_status == 1))
                            {{-- @if($product->hasDeal)
                               ₹ {{(selling_price($product->skus->first()->vip_member_price,$product->hasDeal->discount_type,$product->hasDeal->discount))}}
                            @else
                                @if($product->hasDiscount == 'yes')
                                   ₹ {{(selling_price(@$product->skus->first()->vip_member_price,@$product->discount_type,@$product->discount))}}

                                @else
                                   ₹ {{(@$product->skus->first()->vip_member_price)}}
                                @endif
                            @endif 
                            <span class="">₹ {{(selling_price(@$product->skus->first()->vip_member_price ))}}
                            </span>
                        @else
                            @if($product->hasDeal)
                               ₹ {{(selling_price($product->skus->first()->selling_price,$product->hasDeal->discount_type,$product->hasDeal->discount))}}
                            @else
                                @if($product->hasDiscount == 'yes')
                                   ₹ {{(selling_price(@$product->skus->first()->selling_price,@$product->discount_type,@$product->discount))}}

                                @else
                                   ₹ {{(@$product->skus->first()->selling_price)}}
                                @endif
                            @endif<span class="cutprice">₹ {{(selling_price(@$product->skus->first()->selling_price ))}}
                            </span>
                        @endif
                  </div>
                </div>
              </div>
                </div> --}}
              </div>
             @endforeach
          </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="toptowbanner">
  <div class="container-fluid">
    <div class="row">
      <div class="col-lg-6">
        <div class="banner-content effect-2">
          <a href="{{$offerCollection[3]->data_type}}"><img src="{{$offerCollection[3]->offer_image}}" class="img-fluid"></a>
            <div class="text">
            <h2>{{$offerCollection[3]->name}}</h2>
            <p>{!! $offerCollection[3]->description !!}</p>
           </div>
          </div>
      </div>
      <div class="col-lg-6">
         <div class="banner-content effect-2">
          <a href="{{$offerCollection[4]->data_type}}"><img src="{{$offerCollection[4]->offer_image}}" class="img-fluid"></a>
             <div class="text">
              <h2>{{$offerCollection[4]->name}}</h2>
              <p>{!! $offerCollection[4]->description !!}</p>
           </div>
          </div>
      </div>
    </div>
  </div>
</div>

@php
  $more_products = $widgets->where('section_name','more_products')->first();
@endphp



<div class="arivalproduct tradnign-product pt-50">
  <div class="container-fluid">
    <div class="row mb-4">
        <div class="col-lg-12 text-center">
          <h2>Trending Products</h2>
          <p>Claritas est etiam processus dynamicus, qui sequitur.</p>
        </div>
    </div>
    <div class="row product_block ">
      <div class="product_item owl-carousel owl-theme row">
      @foreach($more_products->getHomePageProductByQuery() as $key => $product)


       <div class="item">
        <div class="product_box_cart tradnign-productbox">
            <div class="img_caption">
              <div class="produt_img">
                <a href="{{singleProductURL($product->seller->slug, $product->slug)}}">
                        <img  @if ($product->thum_img != null) data-src="{{showImage($product->thum_img)}}" @else data-src="{{showImage(@$product->product->thumbnail_image_source)}}" @endif alt="{{@$product->product->product_name}}" src="{{showImage(@$product->product->thumbnail_image_source)}}" class="img-fluid lazyload pic-1">
                    </a>
                 </div>
                <div class="action_inner">
                  <ul>
                    <li><a href="" class="add_to_wishlists {{$product->is_wishlist() == 1?'is_wishlist':''}}" id="wishlistbtn_{{$product->id}}" data-product_id="{{$product->id}}" data-seller_id="{{$product->user_id}}" data-tip=" Wishlist"><i class="bi bi-heart"></i></a></li>
                    {{-- <li><a href="#"><i class="bi bi-eye"></i></a></li> --}}
                  </ul>
                </div>
                <div class="produt_btnclik">
                  {{-- <a href="#" class="btn btn-link cart-bnt"><i class="bi bi-cart"></i> Add to Card</a> --}}
                  <a href="" data-tip="add to cart" class="addToCartFromThumnail btn btn-link cart-bnt" data-producttype="{{ @$product->product->product_type }}" data-seller={{ $product->user_id }} data-product-sku={{ @$product->skus->first()->id }}
                      @if(Auth::user() && Auth::user()->is_membership  && ($product->skus->first()->vip_status == 1))
                        data-base-price={{(selling_price(@$product->skus->first()->vip_member_price ))}}
                      @elseif(@$product->hasDeal)
                        data-base-price={{ selling_price(@$product->skus->first()->selling_price,@$product->hasDeal->discount_type,@$product->hasDeal->discount) }}
                      @else
                          @if($product->hasDiscount == 'yes')
                          data-base-price={{ selling_price(@$product->skus->first()->selling_price,@$product->discount_type,@$product->discount) }}
                          @else
                            data-base-price={{ @$product->skus->first()->selling_price }}
                          @endif
                      @endif
                        data-shipping-method=0
                        data-product-id="{{ $product->id }}"
                        data-stock_manage="{{$product->stock_manage}}"
                        data-stock="{{@$product->skus->first()->product_stock}}"
                        data-min_qty="{{$product->product->minimum_order_qty}}"><i class="bi bi-cart"></i> Add To Cart</a>
                </div>
              </div>
              <div class="product_info">
                <strong class="produt_name">@if($product->product_name != null) {{ \Illuminate\Support\Str::limit(@$product->product_name, 20, $end='...') }} @else {{ \Illuminate\Support\Str::limit(@$product->product->product_name, 15, $end='...') }} @endif</strong>
                <div class="prod_summery">
                  <div class="price">
                        @if(Auth::user()  &&  Auth::user()->is_membership  && ($product->skus->first()->vip_status == 1))
                            {{-- @if($product->hasDeal)
                               ₹ {{(selling_price($product->skus->first()->vip_member_price,$product->hasDeal->discount_type,$product->hasDeal->discount))}}
                            @else
                                @if($product->hasDiscount == 'yes')
                                   ₹ {{(selling_price(@$product->skus->first()->vip_member_price,@$product->discount_type,@$product->discount))}}
                                @else
                                   ₹ {{(@$product->skus->first()->vip_member_price)}}
                                @endif
                            @endif --}}
                            <span class="">₹ {{(selling_price(@$product->skus->first()->vip_member_price ))}}
                            </span>
                        @else
                            @if($product->hasDeal)
                               ₹ {{(selling_price($product->skus->first()->selling_price,$product->hasDeal->discount_type,$product->hasDeal->discount))}}
                            @else
                                @if($product->hasDiscount == 'yes')
                                   ₹ {{(selling_price(@$product->skus->first()->selling_price,@$product->discount_type,@$product->discount))}}

                                @else
                                  ₹ {{(@$product->skus->first()->selling_price)}}
                                @endif
                            @endif<span class="cutprice">₹ {{(selling_price(@$product->skus->first()->selling_price ))}}
                            </span>
                        @endif
                  </div>
                </div>
              </div>
              <div class="product_label">
                <span class="onsale">{{(selling_price(@$product->skus->first()->product_stock ))}}</span>
                @if(getIsNewAttribute($product) == 'true')
                  <span class="newlabel">New </span>
                @endif
              </div>
          </div>
      </div>
      @endforeach
      </div>
    </div>
  </div>
</div>
 
<div class="freeshiping pt-50">
  <div class="container">
    <div class="row">
      <div class="col-lg-4 col-sm-4 border-right">
        <div class="box_freeshi text-center">
            <img src="{{asset('frontend/default/img/Shipping.png')}}" class="img-fluid" alt="img">
            <h3>Free Worldwide Shipping</h3>
            <p>On all orders over $75.00</p>
            <a href="#">Learn More <i class="fa fa-chevron-right"></i></a>
        </div>
      </div>
      <div class="col-lg-4 col-sm-4 border-right">
         <div class="box_freeshi text-center">
            <img src="{{asset('frontend/default/img/paymentsecure.png')}}" class="img-fluid" alt="img">
            <h3>100% Payment Secure</h3>
            <p>We ensure secure payment with PEV</p>
            <a href="#">Learn More <i class="fa fa-chevron-right"></i></a>
        </div>
      </div>
      <div class="col-lg-4 col-sm-4">
        <div class="box_freeshi text-center">
            <img src="{{asset('frontend/default/img/return.png')}}" class="img-fluid" alt="img">
            <h3>30 Days Return</h3>
            <p>Return it within 20 day for an exchange</p>
            <a href="#">Learn More <i class="fa fa-chevron-right"></i></a>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="our_blogarea pt-50 pb-50">
  <div class="container">
    <div class="row">
      <div class="col-lg-12 text-center">
        <h2>From Our Blog</h2>
        <p>Nam liber tempor cum soluta nobis eleifend option congue nihil</p>
      </div>
      <div class="col-lg-12">
        <div class="blog_section owl-carousel owl-theme">
          @foreach($BlogLists as $BlogList)
          <div class="item">
            <div class="blog_product_item">
              <div class="blog_img">
                <a href="#"><img src="{{$BlogList->image_url}}" class="img-fluid">
                  </a>
              </div>
              <div class="blog_content">
                <a href="#" class="in_category">{{$BlogList->category->name ?? ''}}</a>
                <div class="time-conment">
                  <span class="post-date">
                    {{$BlogList->created_at->format('d-m-Y')}}
                   </span>
                </div>
                <h3 class="post-title"><a href="#">{{$BlogList->title}}</a></h3>
                <div class="short-des">{!! Str::limit($BlogList->content ,200)  !!}</div>
                <div class="blog_button">
                  <a href="{{route('blog.single.page',$BlogList->slug)}}" class="readmore">Read More <i class="fa fa-chevron-right"></i></a>
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

{{-- @php
$brands = \Modules\Product\Entities\Brand::get();
@endphp --}}

<div class="brandtop">
  <div class="container">
    <div class="row border-top border-bottom pb-4 pt-4">
      <div class="col-lg-12">
          <div class="brandsection owl-carousel owl-theme">
              <div class="item">
                <div class="brand-image">
                  <img src="{{asset('frontend/default/img/footer_logo1.jpg')}}" class="img-fluid">
                </div>
              </div>
              <div class="item">
                <div class="brand-image">
                <img src="{{asset('frontend/default/img/footer_logo2.jpg')}}" class="img-fluid">
              </div>
              </div>
              <div class="item">
                 <div class="brand-image">
                 <img src="{{asset('frontend/default/img/footer_logo3.jpg')}}" class="img-fluid">
                </div>
              </div>
               <div class="item">
                 <div class="brand-image">
                 <img src="{{asset('frontend/default/img/footer_logo4.jpg')}}" class="img-fluid">
              </div>
              </div>
               <div class="item">
                 <div class="brand-image">
                 <img src="{{asset('frontend/default/img/footer_logo5.jpg')}}" class="img-fluid">
              </div>
              </div>
                 <div class="item">
                   <div class="brand-image">
                   <img src="{{asset('frontend/default/img/footer_logo6.jpg')}}" class="img-fluid">
              </div>
              </div>
              <div class="item">
                   <div class="brand-image">
                   <img src="{{asset('frontend/default/img/footer_logo7.jpg')}}" class="img-fluid">
              </div>
              </div>
              <div class="item">
                   <div class="brand-image">
                   <img src="{{asset('frontend/default/img/footer_logo8.jpg')}}" class="img-fluid">
              </div>
              </div>
          </div>
      </div>
    </div>
  </div> 
</div>
@endsection
@include(theme('partials.add_to_cart_script'))




<div class='sidebar_fixed'>
  <h4 id="showfrom">Request A Fragrent</h4>
  <div class="form_area">
    <h3>Couldn’t find what you are looking for ?? Please help us with details below and we will try to source it for you !!</h3>
    <form action="{{route('request-fragrent')}}" method="POST">
      @csrf
      <div class="form-group">
        <input type="text" class="form-control" name="name" placeholder='Your Name'>
      </div>
      <div class="form-group">
        <input type="email" class="form-control" required name="email" placeholder='Your Email Id'>
      </div>
      <div class="form-group">
        <input type="text" class="form-control" name="phone" maxlength="10"  placeholder='Your Mobile No.' required>
      </div>
      <div class="form-group">
        <input type="text" class="form-control" name="brand" placeholder='Brand' required>
      </div>
      <div class="form-group">
        <input type="text" class="form-control" name="item" placeholder='Item Name' required>
      </div>
      <div class="form-group">
        <input type="text" class="form-control" name="size" placeholder='Size' required>
      </div>
      <div class="form-group">
        <textarea class="form-control" name="message" placeholder="Additional Remark"></textarea>
      </div>
      <button class="btn btn-success btn-block btn-golden mt-3" type='submit' value='submit'>Submit</button>
    </form>
  </div>
</div>




