<div class="category_product_page">
    @php
          $total_number_of_item_per_page = $products->perPage();
          $total_number_of_items = ($products->total() > 0) ? $products->total() : 0;
          $total_number_of_pages = $total_number_of_items / $total_number_of_item_per_page;
          $reminder = $total_number_of_items % $total_number_of_item_per_page;
          if ($reminder > 0) {
            $total_number_of_pages += 1;
          }
          $current_page = $products->currentPage();
          $previous_page = $products->currentPage() - 1;
          if($current_page == $products->lastPage()){
            $show_end = $total_number_of_items;
          }else{
            $show_end = $total_number_of_item_per_page * $current_page;
          }
          $show_start = 0;
          if($total_number_of_items > 0){
            $show_start = ($total_number_of_item_per_page * $previous_page) + 1;
          }

      @endphp

      @isset($category_id)
          <input type="hidden" name="category_id" id="category_id" value="{{ $category_id }}">
      @endisset
    <div class="product_page_tittle d-flex justify-content-between grid_Title_page">
        {{-- <p class="flex-fill display:none">Showing @if($show_start == $show_end) {{$show_end}} @else {{$show_start}} - {{$show_end}} @endif out of total {{$total_number_of_items}} products</p>
        <div class="short_by">
            <select name="paginate_by" class="getFilterUpdateByIndex" id="paginate_by">
                <option value="9" @if (isset($paginate) && $paginate == "9") selected @endif>9</option>
                <option value="12" @if (isset($paginate) && $paginate == "12") selected @endif>12</option>
                <option value="16" @if (isset($paginate) && $paginate == "16") selected @endif>16</option>
                <option value="25" @if (isset($paginate) && $paginate == "25") selected @endif>25</option>
                <option value="30" @if (isset($paginate) && $paginate == "30") selected @endif>30</option>
            </select>
        </div> --}}
        <div><a class="filter_btn" id="modal_view_left" data-toggle="modal"  data-target="#get_quote_modal">Filters</a> </div>
        <div class="short_by" style="margin-left: 800px;">
            <select name="sort_by" class="getFilterUpdateByIndex" id="product_short_list">
                <option disabled selected>Sorting by</option>
                <option value="new" @if (isset($sort_by) && $sort_by == "new") selected @endif>{{ __('common.new') }}</option>
                <option value="old" @if (isset($sort_by) && $sort_by == "old") selected @endif>{{ __('common.old') }}</option>
                <option value="alpha_asc" @if (isset($sort_by) && $sort_by == "alpha_asc") selected @endif>{{ __('defaultTheme.name_a_to_z') }}</option>
                <option value="alpha_desc" @if (isset($sort_by) && $sort_by == "alpha_desc") selected @endif>{{ __('defaultTheme.name_z_to_a') }}</option>
                <option value="low_to_high" @if (isset($sort_by) && $sort_by == "low_to_high") selected @endif>{{ __('defaultTheme.price_low_to_high') }}</option>
                <option value="high_to_low" @if (isset($sort_by) && $sort_by == "high_to_low") selected @endif>{{ __('defaultTheme.price_high_to_low') }}</option>
            </select>
        </div>
    </div>
    @if (app('request')->input('item') == "category" || (isset($item) && $item == "category"))
        <input type="hidden" id="item_request" name="item_request" value="{{ $category_id }}">
        <input type="hidden" id="item_request_type" name="item_request_type" value="category">
    @endif
    @if (app('request')->input('item') == "brand" || (isset($item) && $item == "brand"))
        <input type="hidden" id="item_request" name="item_request" value="{{ $brand_id }}">
        <input type="hidden" id="item_request_type" name="item_request_type" value="brand">
    @endif
    @if (app('request')->input('item') == "tag" || (isset($item) && $item == "tag"))
        <input type="hidden" id="item_request" name="item_request" value="{{ $tag_id }}">
        <input type="hidden" id="item_request_type" name="item_request_type" value="tag">
    @endif

    @if (app('request')->input('item') == "product" || (isset($item) && $item == "product"))
        <input type="hidden" id="item_request" name="item_request" value="{{$section_name}}">
        <input type="hidden" id="item_request_type" name="item_request_type" value="product">
    @endif

    @if (app('request')->input('item') == "search" || (isset($item) && $item == "search"))
        <input type="hidden" id="item_request" name="item_request" value="{{$keyword}}">
        <input type="hidden" id="item_request_type" name="item_request_type" value="search">
    @endif

    @if (app('request')->input('item') == "gender" || (isset($item) && $item == "gender"))
        <input type="hidden" id="item_request" name="item_request" value="{{$gender}}">
        <input type="hidden" id="item_request_type" name="item_request_type" value="gender">
    @endif

    <div class="column_product_box">
    <div class="row">
    @if(count($products)>0)

        @foreach($products as $product)
            @if(get_class($product) == \Modules\Seller\Entities\SellerProduct::class)
                {{-- {{dd($product)}} --}}
               {{--  <div class="col-lg-4 col-sm-4 col-md-6 single_product_item">
                    <div class="single_product_list product_tricker">
                        <div class="product_img">
                            <a href="{{singleProductURL(@$product->seller->slug, $product->slug)}}" class="product_img_iner">
                                <img @if ($product->thum_img != null) src="{{asset(asset_path($product->thum_img))}}" @else src="{{asset(asset_path(@$product->product->thumbnail_image_source))}}" @endif alt="{{@$product->product->product_name}}" class="img-fluid" />
                            </a>
                            <div class="socal_icon">
                                <a href="" class="add_to_wishlist {{@$product->is_wishlist() == 1?'is_wishlist':''}}" id="wishlistbtn_{{$product->id}}" data-product_id="{{$product->id}}" data-seller_id="{{$product->user_id}}"> <i class="ti-heart"></i> </a>
                                <a href="" class="addToCompareFromThumnail" data-producttype="{{ @$product->product->product_type }}" data-seller={{ $product->user_id }} data-product-sku={{ @$product->skus->first()->id }} data-product-id={{ $product->id }}> <i class="ti-exchange-vertical"></i> </a>
                                <a class="addToCartFromThumnail" data-producttype="{{ @$product->product->product_type }}" data-seller={{ $product->user_id }} data-product-sku={{ @$product->skus->first()->id }}
                                    @if(@$product->hasDeal)
                                    data-base-price={{ selling_price(@$product->skus->first()->selling_price,@$product->hasDeal->discount_type,@$product->hasDeal->discount) }}
                                    @else
                                        @if(@$product->hasDiscount)
                                            data-base-price={{ selling_price(@$product->skus->first()->selling_price,$product->discount_type,$product->discount) }}
                                        @else
                                            data-base-price={{ $product->skus->first()->selling_price }}
                                        @endif
                                    @endif
                                    data-shipping-method=0
                                    data-product-id={{ $product->id }}
                                    data-stock_manage="{{$product->stock_manage}}"
                                    data-stock="{{@$product->skus->first()->product_stock}}"
                                    data-min_qty="{{@$product->product->minimum_order_qty}}"> <i class="ti-bag"></i> 
                                </a>
                            </div>
                        </div>
                        <div class="product_text">
                            <h5>
                                <a href="{{singleProductURL(@$product->seller->slug, $product->slug)}}">@if ($product->product_name) {{ substr($product->product_name,0,28) }} @if(strlen($product->product_name) > 28)... @endif @else {{substr(@$product->product->product_name,0,28)}} @if(strlen(@$product->product->product_name) > 28)... @endif @endif</a>
                            </h5>
                            <div class="product_review_star d-flex justify-content-center align-items-center">
                                <p>
                                    @if(@$product->hasDeal)
                                        @if (@$product->product->product_type == 1)
                                            {{single_price(selling_price(@$product->skus->first()->selling_price,@$product->hasDeal->discount_type,@$product->hasDeal->discount))}}
                                        @else
                                            @if (selling_price(@$product->skus->min('selling_price'),@$product->hasDeal->discount_type,@$product->hasDeal->discount) === selling_price(@$product->skus->max('selling_price'),@$product->hasDeal->discount_type,@$product->hasDeal->discount))
                                                {{single_price(selling_price($product->skus->min('selling_price'),$product->hasDeal->discount_type,$product->hasDeal->discount))}}
                                            @else
                                                {{single_price(selling_price(@$product->skus->min('selling_price'),@$product->hasDeal->discount_type,@$product->hasDeal->discount))}} - {{single_price(selling_price(@$product->skus->max('selling_price'),@$product->hasDeal->discount_type,@$product->hasDeal->discount))}}
                                            @endif
                                        @endif
                                    @else
                                        @if (@$product->product->product_type == 1)
                                            @if($product->hasDiscount == 'yes')
                                                {{single_price(selling_price(@$product->skus->first()->selling_price,$product->discount_type,$product->discount))}}
                                            @else
                                                {{single_price(@$product->skus->first()->selling_price)}}
                                            @endif
                                        @else
                                            @if(@$product->hasDiscount == 'yes')
                                                @if (selling_price(@$product->skus->min('selling_price'),$product->discount_type,$product->discount) === selling_price(@$product->skus->max('selling_price'),$product->discount_type,$product->discount))
                                                    {{single_price(selling_price($product->skus->min('selling_price'),$product->discount_type,$product->discount))}}
                                                @else
                                                    {{single_price(selling_price(@$product->skus->min('selling_price'),$product->discount_type,$product->discount))}} - {{single_price(selling_price(@$product->skus->max('selling_price'),$product->discount_type,$product->discount))}}
                                                @endif
                                            @else
                                                @if (@$product->skus->min('selling_price') === @$product->skus->max('selling_price'))
                                                    {{single_price($product->skus->min('selling_price'))}}
                                                @else
                                                    {{single_price(@$product->skus->min('selling_price'))}} - {{single_price(@$product->skus->max('selling_price'))}}
                                                @endif
                                            @endif
                                        @endif
                                    @endif
                                </p>
                            <div class="review_star_icon">
                                @php
                                    $reviews = @$product->reviews->where('status',1)->pluck('rating');
                                    
                                    if(count($reviews)>0){
                                        $value = 0;
                                        $rating = 0;
                                        foreach($reviews as $review){
                                            $value += $review;
                                        }
                                        $rating = $value/count($reviews);
                                        $total_review = count($reviews);
                                    }else{
                                        $rating = 0;
                                        $total_review = 0;
                                    }
                                @endphp
                                @if($rating == 0)
                                <i class="fas fa-star non_rated "></i>
                                <i class="fas fa-star non_rated "></i>
                                <i class="fas fa-star non_rated "></i>
                                <i class="fas fa-star non_rated "></i>
                                <i class="fas fa-star non_rated "></i>
                                @elseif($rating < 1 && $rating > 0)
                                <i class="fas fa-star-half-alt"></i>
                                <i class="fas fa-star non_rated "></i>
                                <i class="fas fa-star non_rated "></i>
                                <i class="fas fa-star non_rated "></i>
                                <i class="fas fa-star non_rated "></i>
                                @elseif($rating <= 1 && $rating > 0)
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star non_rated "></i>
                                <i class="fas fa-star non_rated "></i>
                                <i class="fas fa-star non_rated "></i>
                                <i class="fas fa-star non_rated "></i>
                                @elseif($rating < 2 && $rating > 1)
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star-half-alt"></i>
                                <i class="fas fa-star non_rated "></i>
                                <i class="fas fa-star non_rated "></i>
                                <i class="fas fa-star non_rated "></i>
                                @elseif($rating <= 2 && $rating > 1)
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star non_rated "></i>
                                <i class="fas fa-star non_rated "></i>
                                <i class="fas fa-star non_rated "></i>
                                @elseif($rating < 3 && $rating > 2)
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star-half-alt"></i>
                                <i class="fas fa-star non_rated "></i>
                                <i class="fas fa-star non_rated "></i>
                                @elseif($rating <= 3 && $rating > 2)
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star "></i>
                                <i class="fas fa-star non_rated "></i>
                                <i class="fas fa-star non_rated "></i>
                                @elseif($rating < 4 && $rating > 3)
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star "></i>
                                <i class="fas fa-star-half-alt"></i>
                                <i class="fas fa-star non_rated "></i>
                                @elseif($rating <= 4 && $rating > 3)
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star "></i>
                                <i class="fas fa-star "></i>
                                <i class="fas fa-star non_rated "></i>
                                @elseif($rating < 5 && $rating > 4)
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star "></i>
                                <i class="fas fa-star "></i>
                                <i class="fas fa-star-half-alt"></i>
                                @else
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star "></i>
                                <i class="fas fa-star "></i>
                                <i class="fas fa-star "></i>
                                @endif
                            </div>
                            </div>
                            <div class="product_review_count d-flex justify-content-between align-items-center">
                                <span>
                                    @if(@$product->hasDeal)
                                        @if(@$product->hasDeal->discount > 0)
                                            @if (@$product->product->product_type == 1)
                                                {{single_price(@$product->skus->first()->selling_price)}}
                                            @else
                                                @if (@$product->skus->min('selling_price') === @$product->skus->max('selling_price'))
                                                    {{single_price(@$product->skus->min('selling_price'))}}
                                                @else
                                                    {{single_price(@$product->skus->min('selling_price'))}} - {{single_price(@$product->skus->max('selling_price'))}}
                                                @endif
                                            @endif
                                        @endif
                                    @else
                                        @if(@$product->hasDiscount == 'yes')
                                            @if($product->discount > 0)
                                                @if (@$product->product->product_type == 1)
                                                    {{single_price(@$product->skus->first()->selling_price)}}
                                                @else
                                                    @if (@$product->skus->min('selling_price') === @$product->skus->max('selling_price'))
                                                        {{single_price(@$product->skus->min('selling_price'))}}
                                                    @else
                                                        {{single_price(@$product->skus->min('selling_price'))}} - {{single_price(@$product->skus->max('selling_price'))}}
                                                    @endif
                                                @endif
                                            @endif
                                            
                                        @endif
                                    @endif
                                </span>
                            
                                <p>{{sprintf("%.2f",$rating)}}/5 ({{$total_review<10?'0':''}}{{$total_review}} Review)</p>
                            </div>
                            @if($product->hasDeal)
                                @if(@$product->hasDeal->discount > 0)
                                    <span class="price_off">
                                        @if(@$product->hasDeal->discount_type == 0)
                                            {{@$product->hasDeal->discount}} % off
                                        @else
                                            {{single_price(@$product->hasDeal->discount)}} off
                                        @endif
                                    </span>
                                @endif
                            @else
                                @if(@$product->hasDiscount == 'yes')
                                    @if($product->discount > 0)
                                        <span class="price_off">
                                            @if($product->discount_type == 0)
                                                {{$product->discount}} % off
                                            @else
                                                {{single_price($product->discount)}} off
                                            @endif
                                        </span>
                                    @endif
                                @endif
                            @endif
                        </div>
                    </div>
                </div> --}}
     {{-- {{dd($product)}} --}}
                <div class="col-auto">
                    <div class="product_box_cart tradnign-productbox">
                        <div class="img_caption">
                          <div class="produt_img">
                            <a href="{{singleProductURL(@$product->seller->slug, $product->slug)}}" class="product_img_iner">
                                <img @if ($product->thum_img != null) src="{{asset(asset_path($product->thum_img))}}" @else src="{{asset(asset_path(@$product->product->gallary_images[0]->images_source))}}" @endif alt="{{@$product->product->product_name}}" class="img-fluid" />
                            </a>
                             </div>
                            <div class="action_inner">
                              <ul>
                                {{-- <li><a href="#"><i class="bi bi-heart"></i></a></li> --}}
                                <li><a href="" class="add_to_wishlist {{@$product->is_wishlist() == 1?'is_wishlist':''}}" id="wishlistbtn_{{$product->id}}" data-product_id="{{$product->id}}" data-seller_id="{{$product->user_id}}"> <i class="bi bi-heart"></i> </a></li>
                                {{-- <li><a href="#"><i class="bi bi-eye"></i></a></li> --}}
                              </ul>
                            </div>
                            <div class="produt_btnclik">
                              {{-- <a href="#" class="btn btn-link cart-bnt"><i class="bi bi-cart"></i> Add to Card</a> --}}
                              <a class="addToCartFromThumnail btn btn-link cart-bnt" data-producttype="{{ @$product->product->product_type }}" data-seller={{ $product->user_id }} data-product-sku={{ @$product->skus->first()->id }}
                                    @if(Auth::user() && Auth::user()->is_membership  && ($product->skus->first()->vip_status == 1))
                                       data-base-price={{(selling_price(@$product->skus->first()->vip_member_price ))}}
                                    @elseif(@$product->hasDeal)
                                    data-base-price={{ selling_price(@$product->skus->first()->selling_price,@$product->hasDeal->discount_type,@$product->hasDeal->discount) }}
                                    @else
                                        @if(@$product->discount_type == 1)
                                            data-base-price={{ selling_price(@$product->skus->first()->selling_price,$product->discount_type,$product->discount) }}
                                        @else
                                            data-base-price={{ $product->skus->first()->selling_price }}
                                        @endif
                                    @endif
                                    data-shipping-method=0
                                    @if($product->product_type == 2)
                                        data-product-id={{ $product->id }}
                                    @else
                                        data-product-id={{ $product->product->id }}
                                    @endif
                                
                                    data-stock_manage="{{$product->stock_manage}}"
                                    data-stock="{{@$product->skus->first()->product_stock}}"
                                    data-min_qty="{{@$product->product->minimum_order_qty}}"> <i class="bi bi-cart"></i> 
                                Add To Cart</a>
                            </div>
                          </div>
                          <div class="product_info">
                            <strong class="produt_name">@if ($product->product_name) {{ substr($product->product_name,0,300) }} @if(strlen($product->product_name) > 300)... @endif @else {{substr(@$product->product->product_name,0,300)}} @if(strlen(@$product->product->product_name) > 300)... @endif @endif</strong>
                            <div class="prod_summery">
                            <div class="price">
                        @if(Auth::user()  &&  Auth::user()->is_membership  && ($product->skus->first()->vip_status == 1))
                            {{-- @if($product->hasDeal)
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
                            <span class="">₹ {{(selling_price(@$product->skus->first()->vip_member_price ))}}
                            </span>
                        @elseif($product->discount == 0.0 )
                            ₹ {{(@$product->skus->first()->selling_price)}}
                        @else
                            @if($product->hasDeal)
                               ₹ {{(selling_price($product->skus->first()->selling_price,$product->hasDeal->discount_type,$product->hasDeal->discount))}}
                            @else
                                @if($product->hasDiscount == 'yes')
                                   ₹ {{(selling_price(@$product->skus->first()->selling_price,@$product->discount_type,@$product->discount))}}
                                @elseif($product->discount > 0)
                                   ₹ {{(@$product->skus->first()->selling_price)}}
                                @else
                                   ₹ {{(@$product->skus->first()->selling_price)}}
                                @endif
                            @endif
                            <span class="cutprice">₹ {{(selling_price(@$product->skus->first()->selling_price ))}}</span>
                        @endif
                            </div>
                            </div>
                          </div>
                          <div class="product_label">
                            {{-- <span class="onsale">{{@$product->skus->first()->product_stock}}</span> --}}
                            @if(getIsNewAttribute($product) == 'true')
                              <span class="newlabel">New</span>
                            @endif
                          </div>
                      </div>
                    </div>

           {{--  @else
                
                <div class="col-lg-4 col-sm-4 col-md-6 single_product_item">
                
                    <div class="single_product_list product_tricker">
                        <div class="product_img">
                            <a href="{{route('frontend.gift-card.show',$product->slug)}}" class="product_img_iner">
                                <img src="{{asset(asset_path($product->thumbnail_image))}}" alt="{{@$product->product_name}}" class="img-fluid" />
                            </a>
                            <div class="socal_icon">
                                <a href="" class="add_to_wishlist_from_search {{$product->IsWishlist == 1?'is_wishlist':''}}" id="wishlistbtn_{{$product->id}}" data-product_id="{{$product->id}}" data-type="gift_card" data-seller_id="{{ App\Models\User::where('role_id', 1)->first()->id }}"> <i class="ti-heart"></i> </a>
                                <a class="add_to_cart_gift_thumnail" data-gift-card-id="{{ $product->id }}" data-seller="{{ App\Models\User::where('role_id', 1)->first()->id }}" data-base-price="@if($product->hasDiscount()) {{selling_price($product->selling_price, $product->discount_type, $product->discount)}} @else {{$product->selling_price}} @endif"> <i class="ti-bag"></i> </a>
                            </div>
                        </div>
                        <div class="product_text">
                            <h5>
                                <a href="{{route('frontend.gift-card.show',$product->slug)}}">@if ($product->product_name) {{ substr($product->product_name,0,28) }} @if(strlen($product->product_name) > 28)... @endif  @endif</a>
                            </h5>
                            <div class="product_review_star d-flex justify-content-between align-items-center">
                                @if($product->hasDiscount())
                                    <p>{{single_price(selling_price($product->selling_price, $product->discount_type, $product->discount))}}</p>
                                @else
                                    <p>{{single_price($product->selling_price)}}</p>
                                @endif
                            <div class="review_star_icon">
                                @php
                                    $reviews = @$product->reviews->where('status',1)->pluck('rating');
                                    
                                    if(count($reviews)>0){
                                        $value = 0;
                                        $rating = 0;
                                        foreach($reviews as $review){
                                            $value += $review;
                                        }
                                        $rating = $value/count($reviews);
                                        $total_review = count($reviews);
                                    }else{
                                        $rating = 0;
                                        $total_review = 0;
                                    }
                                @endphp
                                @if($rating == 0)
                                <i class="fas fa-star non_rated "></i>
                                <i class="fas fa-star non_rated "></i>
                                <i class="fas fa-star non_rated "></i>
                                <i class="fas fa-star non_rated "></i>
                                <i class="fas fa-star non_rated "></i>
                                @elseif($rating < 1 && $rating > 0)
                                <i class="fas fa-star-half-alt"></i>
                                <i class="fas fa-star non_rated "></i>
                                <i class="fas fa-star non_rated "></i>
                                <i class="fas fa-star non_rated "></i>
                                <i class="fas fa-star non_rated "></i>
                                @elseif($rating <= 1 && $rating > 0)
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star non_rated "></i>
                                <i class="fas fa-star non_rated "></i>
                                <i class="fas fa-star non_rated "></i>
                                <i class="fas fa-star non_rated "></i>
                                @elseif($rating < 2 && $rating > 1)
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star-half-alt"></i>
                                <i class="fas fa-star non_rated "></i>
                                <i class="fas fa-star non_rated "></i>
                                <i class="fas fa-star non_rated "></i>
                                @elseif($rating <= 2 && $rating > 1)
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star non_rated "></i>
                                <i class="fas fa-star non_rated "></i>
                                <i class="fas fa-star non_rated "></i>
                                @elseif($rating < 3 && $rating > 2)
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star-half-alt"></i>
                                <i class="fas fa-star non_rated "></i>
                                <i class="fas fa-star non_rated "></i>
                                @elseif($rating <= 3 && $rating > 2)
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star "></i>
                                <i class="fas fa-star non_rated "></i>
                                <i class="fas fa-star non_rated "></i>
                                @elseif($rating < 4 && $rating > 3)
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star "></i>
                                <i class="fas fa-star-half-alt"></i>
                                <i class="fas fa-star non_rated "></i>
                                @elseif($rating <= 4 && $rating > 3)
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star "></i>
                                <i class="fas fa-star "></i>
                                <i class="fas fa-star non_rated "></i>
                                @elseif($rating < 5 && $rating > 4)
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star "></i>
                                <i class="fas fa-star "></i>
                                <i class="fas fa-star-half-alt"></i>
                                @else
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star "></i>
                                <i class="fas fa-star "></i>
                                <i class="fas fa-star "></i>
                                @endif
                            </div>
                            </div>
                            <div class="product_review_count d-flex justify-content-between align-items-center">
                                <span>
                                    @if($product->hasDiscount())
                                        @if($product->discount > 0)
                                        {{single_price($product->selling_price)}}
                                        @endif
                                    @endif
                                </span>
                                <p>{{sprintf("%.2f",$rating)}}/5 ({{$total_review<10?'0':''}}{{$total_review}} Review)</p>
                            </div>
                            
                        </div>
                    </div>
                </div> --}}
            @endif
        @endforeach

    @else
       <div class="text-center no_product_found">
           <span class="product_not_found">{{ __('defaultTheme.no_product_found') }}</span>
       </div>
    @endif

    </div>
    </div>

    <input type="hidden" name="filterCatCol" class="filterCatCol" value="0">

    @if(count($products)>0)
    <div class="col-lg-12">

      <div class="pagination_part">
          <nav aria-label="Page navigation example">
              <ul class="pagination">
                  <li class="page-item"><a class="page-link" href="{{ $products->previousPageUrl() }}"> <i class="ti-arrow-left"></i> </a></li>
                  @for ($i=1; $i <= $total_number_of_pages; $i++)
                      @if (($products->currentPage() + 2) == $i)
                          <li class="page-item"><a class="page-link" href="{{ $products->url($i) }}">{{ $i }}</a></li>
                      @endif
                      @if (($products->currentPage() + 1) == $i)
                          <li class="page-item"><a class="page-link" href="{{ $products->url($i) }}">{{ $i }}</a></li>
                      @endif
                      @if ($products->currentPage() == $i)
                          <li class="page-item @if (request()->toRecievedList == $i || request()->toRecievedList == null) active @endif"><a class="page-link" href="{{ $products->url($i) }}">{{ $i }}</a></li>
                      @endif
                      @if (($products->currentPage() - 1) == $i)
                          <li class="page-item"><a class="page-link" href="{{ $products->url($i) }}">{{ $i }}</a></li>
                      @endif
                      @if (($products->currentPage() - 2) == $i)
                          <li class="page-item"><a class="page-link" href="{{ $products->url($i) }}">{{ $i }}</a></li>
                      @endif
                  @endfor
                  <li class="page-item"><a class="page-link" href="{{ $products->nextPageUrl() }}"> <i class="ti-arrow-right"></i> </a></li>
              </ul>
          </nav>
      </div>
    </div>

    @endif

</div>
