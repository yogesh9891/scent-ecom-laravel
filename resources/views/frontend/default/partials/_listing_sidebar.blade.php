<div class="col-lg-12">
    <div class="modal modal_outer left_modal fade" id="get_quote_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel2" >
        <div class="modal-dialog" role="document">
            <div class="modal-content ">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <div class="modal-header">
                  <h2 class="modal-title">FILTERS </h2>
                  <button  type="button" class="clearbtn btn btn-primary" id="clearFilter">
                    Clear Filter <i class="bi bi-x"></i>
                  </button>
                </div>
                <div class="modal-body get_quote_view_modal_body">
                    <div class="category_sidebar">
                        <div class="category_refress">




                            <a href="" id="refresh_btn">{{ __('defaultTheme.refresh_filters') }}</a>
                            <i class="ti-reload"></i>
                        </div>
@isset($CategoryList)
@if (count($CategoryList) > 0)
<div id="sidebarlist_accrodion">
  <div id="accordion" class="newpassword_accriond">
  <div class="card">
    <div class="card-header" id="headingOne">
      <h5 class="mb-0">
        <a href="#" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
         Gender  
        </a>
      </h5>
    </div>
    <div id="collapseOne" class="collapse @if(request()->get('item') == 'gender') show @endif" aria-labelledby="headingOne" data-parent="#accordion">
        <div class="card-body">
            @php  $genders = ['his','her','unisex'];  @endphp
            <ul>
            @foreach($genders as $key => $gender)
            @if(strtolower($gender))
            <li> 
                <label for="Men"> {{ $gender }}</label>
                <input type="checkbox"  @if(request()->get('item') == 'gender' && $slug == $gender)   checked  @endif class="getProductByChoice " data-id="gender" data-value="{{$gender}}" id="{{$gender}}"> 
            </li>
            @endif
            @endforeach 
            </ul>
        </div>
    </div>
  </div>
  <div class="card">
    <div class="card-header" id="headingTwo">
      <h5 class="mb-0">
        <a class=" collapsed" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
          Category
        </a>
      </h5>
    </div>
    <div id="collapseTwo" class="collapse @if(request()->get('item') == 'category') show @endif"  aria-labelledby="headingTwo" data-parent="#accordion">
      <div class="card-body">
       
            <div class="single_category_option">
                <nav>
                    {{-- {{dd($CategoryList)}} --}}
                    <ul>
                    @foreach($CategoryList as $key => $category)
                        <li class='sub-menu'><label   for="{{ $category->id }}">{{$category->name}}</label><input type='checkbox' class="getProductByChoice" data-id="cat" data-value="{{ $category->id }}"  @if( $slug == $category->slug) checked @endif />
                        <ul>
                        @foreach($category->subCategories as $key => $subCategory)
                            <li>
                            <a class="getProductByChoice" data-id="cat" data-value="{{ $subCategory->id }}">{{$subCategory->name}}</a>
                        <label class="cs_checkbox">
                            <input type="checkbox" class="getProductByChoice category_checkbox" data-id="cat" data-value="{{ $subCategory->id }}">
                            <span class="checkmark"></span>
                        </label>
                            </li>
                        @endforeach
                        </ul>
                        </li>
                    @endforeach
                    </ul>
                </nav>
            

        </div>
      </div>
    </div>
  </div>
@endif
@endisset          
@isset ($brandList)
@if (count($brandList) > 0)
{{-- {{dd($brandList, "brand list")}} --}}
  <div class="card">
    <div class="card-header" id="headingThree">
    <h5 class="mb-0">
      <a class="collapsed" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
        Brand
      </a>
    </h5>
    </div>
    <div id="collapseThree" class="collapse  @if(request()->get('item') == 'brand') show @endif" aria-labelledby="headingThree" data-parent="#accordion">
      <div class="card-body">
        <ul>
        @foreach($brandList as $key => $brand)
            <li><label for="{{ $brand->id }}">{{ $brand->name }}</label> <input type="checkbox"  @if( $slug == $brand->slug) checked @endif id="{{ $brand->id }}" class="getProductByChoice" data-id="brand" data-value="{{ $brand->id }}"> </li>
        @endforeach
        </ul>
      </div>
    </div>
  </div>
  @endif
    @endisset            
{{--     @isset($attributeLists)
    @foreach ($attributeLists as $key => $attribute)

  <div class="card">
    <div class="card-header" id="headingFour">
      <h5 class="mb-0">
        <a class=" collapsed" data-toggle="collapse" data-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
          {{ $attribute->name }}
        </a>
      </h5>
    </div>
    <div id="collapseFour" class="collapse" aria-labelledby="headingFour" data-parent="#accordion">
      <div class="card-body">
        <ul>
        @foreach ($attribute->values as $key => $attr_value)
            <li><label for="Armani"> {{ $attr_value->value }}</label> <input type="checkbox" name="attr_value[]" class="attr_checkbox getProductByChoice" data-id="{{ $attribute->id }}" data-value="{{ $attr_value->id }}"  id="{{ $attr_value->id }}"> </li>
        @endforeach
        </ul>
      </div>
    </div>
  </div>
  @endforeach
    @endisset  --}}           
    <div class="single_category price_rangs">
        <div class="category_tittle">
            <h4>{{ __('defaultTheme.price_range') }}</h4>
        </div>
        <div class="single_category_option" id="price_range_div">
            <div class="wrapper">
           {{--      <div class="range-slider">
                    <input type="text" class="js-range-slider-0" value=""/>
                </div> --}}
                <div class="extra-controls form-inline">
                <div class="form-group">
                    <div class="price_rangs">     
                        <input type="text" class="js-input-from form-control" id="min_price" value="{{ $min_price_lowest }}" />
                    <p>{{ __('common.min') }}</p>
                    </div>
                <div class="price_rangs">
                    <input type="text" class="js-input-to form-control" id="max_price" value="{{ $max_price_highest }}" />
                        <p>{{ __('common.max') }}</p>
                </div>
                </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>



                        {{-- <div id="sidebarlist_accrodion">
                            <div class="accordion" id="faq">
                                    <div class="card">
                                        <div class="card-header" id="faqhead1">
                                            <a href="#" class="btn btn-header-link collapsed" data-toggle="collapse" data-target="#faq1"
                                            aria-expanded="true" aria-controls="faq1">Gender</a>
                                        </div>
                                        @php  $genders = ['his','her','unisex'];  @endphp
                                        <div id="faq1" class="collapse" aria-labelledby="faqhead1" data-parent="#faq">
                                            <div class="card-body">
                                                <ul>
                                                  @foreach($genders as $key => $gender)
                                                  @if(strtolower($gender))
                                                    <li> <input type="checkbox"  class="getProductByChoice category_checkbox" data-id="cat" data-value="" id=""> <label for="Men"> {{ $gender }}</label></li>
                                                    @endif
                                                  @endforeach 
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                             
                                <div class="accordion" id="faq2">              
                                <div class="card">
                                <div class="card-header" id="faqhead2">
                                    <a href="#" class="btn btn-header-link collapsed" data-toggle="collapse" data-target="#faq2"
                                    aria-expanded="true" aria-controls="faq2">Category</a>
                                </div>
                                <div id="faq2" class="collapse" aria-labelledby="faqhead2" data-parent="#faq">
                                    <div class="card-body">
                                    <div class="single_category_option">
                                    <nav>
                                        <ul>
                                            @foreach($CategoryList as $key => $category)
                                            <li class='sub-menu'><a class="getProductByChoice" data-id="cat" data-value="{{ $category->id }}">{{$category->name}}<div class='ti-plus right'></div></a>
                                                <ul>
                                                    @foreach($category->subCategories as $key => $subCategory)
                                                        <li>
                                                            <a class="getProductByChoice" data-id="cat" data-value="{{ $subCategory->id }}">{{$subCategory->name}}</a>
                                                            <label class="cs_checkbox">
                                                                <input type="checkbox" class="getProductByChoice category_checkbox" data-id="cat" data-value="{{ $subCategory->id }}">
                                                                <span class="checkmark"></span>
                                                            </label>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            </li>
                                            @endforeach
                                        </ul>
                                    </nav>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                            <div id="sidebarlist_accrodion">
                            <div class="accordion" id="faq">
                                <div class="card">
                                        <div class="card-header" id="faqhead3">
                                            <a href="#" class="btn btn-header-link collapsed" data-toggle="collapse" data-target="#faq3"
                                            aria-expanded="true" aria-controls="faq3">Brand</a>
                                        </div>
                                        <div id="faq3" class="collapse" aria-labelledby="faqhead3" data-parent="#faq">
                                            <div class="card-body">
                                                <ul>
                                                  @foreach($brandList as $key => $brand)
                                                    <li> <input type="checkbox" id="{{ $brand->id }}" class="getProductByChoice" data-id="brand" data-value="{{ $brand->id }}"> <label for="{{ $brand->id }}">{{ $brand->name }}</label></li>
                                                  @endforeach
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>    
                            </div>
                            @endif
                        @endisset
                        @isset($attributeLists)
                        @foreach ($attributeLists as $key => $attribute)
                            <div class="single_category materials_content ">
                                <div id="sidebarlist_accrodion" class="category_part">
                                  <div class="accordion category_sidebar" id="faq2">
                                    <div class="card">
                                        <div class="card-header" id="faqhead6">
                                            <a href="#" class="btn btn-header-link collapsed" data-toggle="collapse" data-target="#faq2"
                                            aria-expanded="true" aria-controls="faq2">{{ $attribute->name }}</a>
                                        </div>
                                        <div id="faq2" class="collapse" aria-labelledby="faqhead6" data-parent="#faq2">
                                            <div class="card-body single_category">
                                                <div class="single_category_option">
                                                    <nav>
                                                <ul>
                                                  @foreach ($attribute->values as $key => $attr_value)
                                                    <li> <input type="checkbox" name="attr_value[]" class="attr_checkbox getProductByChoice" data-id="{{ $attribute->id }}" data-value="{{ $attr_value->id }}"  id="{{ $attr_value->id }}"> <label for="Armani"> {{ $attr_value->value }}</label></li>
                                                  @endforeach
                                                </ul>
                                                    </nav>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                 </div>
                                </div>
                            </div>
                        @endforeach
                        @endisset
                        <div class="single_category price_rangs">
                            <div class="category_tittle">
                                <h4>{{ __('defaultTheme.price_range') }}</h4>
                            </div>
                            <div class="single_category_option" id="price_range_div">
                                <div class="wrapper">
                                    <div class="range-slider">
                                        <input type="text" class="js-range-slider-0" value=""/>
                                    </div>
                                    <div class="extra-controls form-inline">
                                        <div class="form-group">
                                            <div class="price_rangs">
                                                
                                                <input type="text" class="js-input-from form-control" id="min_price" value="{{ $min_price_lowest }}" readonly/>
                                                <p>{{ __('common.min') }}</p>
                                            </div>
                                            <div class="price_rangs">
                                                <input type="text" class="js-input-to form-control" id="max_price" value="{{ $max_price_highest }}" readonly/>
                                                <p>{{ __('common.max') }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        </div>
                        </div> --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
