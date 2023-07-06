@extends('frontend.default.layouts.app')
@section('styles')
<link rel="stylesheet" href="{{asset(asset_path('frontend/default/css/page_css/listing.css'))}}" />

<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">
@endsection
@section('breadcrumb')
    @isset($filter_name)
        {{ $filter_name->name ?? $filter_name }}
    @else
        {{ $tag }}
    @endisset
@endsection
@section('title')
    @isset($filter_name)
        {{ $filter_name->name ?? $filter_name }}
    @else
        {{ $tag }}
    @endisset
@endsection

@section('content')

@include('frontend.default.partials._breadcrumb')

<div class="aboutimgbg-top">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <h3>Category</h3>
            </div>
        </div>
    </div>
</div>
    <!-- catrgory part here -->
<section class="category_part single_page_category">
    <div class="container-fluid">
        <div class="row">
            @include('frontend.default.partials._listing_sidebar')
            <div id="dataWithPaginate"class="col-lg-12">
                @include('frontend.default.partials.listing_paginate_data')
            </div>
        </div>
    </div>
    <div class="add-product-to-cart-using-modal"></div>
    <input type="hidden" id="login_check" value="@if(auth()->check()) 1 @else 0 @endif">
</section>

<!-- catrgory part end -->
@endsection
@include(theme('partials.add_to_cart_script'))
@include(theme('partials.add_to_compare_script'))
@push('scripts')
    <script type="text/javascript">

        (function($){
            "use strict";

            var filterType = [];

            $(document).ready(function(){

                '@if (isset($color) && $color != null)'+
                    '@foreach ($color->values as $ki => $item)'+
                        $(".colors_{{$ki}}").css("background-color", "{{ $item->value }}");
                    '@endforeach'+
                '@endif'
                $('#clearFilter').click(function (argument) {
     $(".getProductByChoice").prop('checked', false);
})
                $(document).on('click', '#refresh_btn', function(event){
                    event.preventDefault();
                    filterType = [];
                    fetch_data(1);

                    $('.attr_checkbox').prop('checked', false);
                    $('.color_checkbox').removeClass('selected_btn');
                    $('.category_checkbox').prop('checked', false);

                    $('#price_range_div').html(
                        `<div class="wrapper">
                        <div class="range-slider">
                            <input type="text" class="js-range-slider-0" value=""/>
                        </div>
                        <div class="extra-controls form-inline">
                            <div class="form-group">
                                <div class="price_rangs">
                                    <input type="text" class="js-input-from form-control" id="min_price" value="{{ isset($min_price_lowest) ? $min_price_lowest : 0 }}" readonly/>
                                    <p>Min</p>
                                </div>
                                <div class="price_rangs">
                                    <input type="text" class="js-input-to form-control" id="max_price" value="{{ isset($max_price_highest) ? $max_price_highest : 0 }}" readonly/>
                                    <p>Max</p>
                                </div>
                            </div>
                        </div>
                    </div>`

                    );

                    $(".js-range-slider-0").ionRangeSlider({
                        type: "double",
                        min: $('#min_price').val(),
                        max: $('#max_price').val(),
                        from: $('#min_price').val(),
                        to: $('#max_price').val(),
                        drag_interval: true,
                        min_interval: null,
                        max_interval: null
                    });

                });

                $(document).on('click', '.getProductByChoice', function(event){
                    let type = $(this).data('id');
                    let el = $(this).data('value');
                        if ($(this).is(':checked')) {
                            getProductByChoice(type, el);
                        } else {
                            getProductByChoice(type, el,false);

                        }
                });

                $(document).on('click', '.color_checkbox', function(event){
                    if ($(this).is(':checked')) {
                        $(this).addClass('selected_btn');
                    }else {
                        $(this).removeClass('selected_btn');
                    }
                });


                $(document).on('click', '.page-item a', function(event){
                    event.preventDefault();
                    let page = $(this).attr('href').split('page=')[1];

                    var filterStatus = $('.filterCatCol').val();
                    if (filterStatus == 0) {
                        fetch_data(page);
                    }
                    else {
                        fetch_filter_data(page);
                    }

                });

                $(document).on('click', ".add_to_cart_gift_thumnail", function() {
                    addToCart($(this).attr('data-gift-card-id'),$(this).attr('data-seller'),1,$(this).attr('data-base-price'),1,'gift_card');
                });

                $(document).on('click', '.add_to_wishlist_from_search', function(event){
                    event.preventDefault();
                    let product_id = $(this).data('product_id');
                    let type = $(this).data('type');
                    let seller_id = $(this).data('seller_id');
                    let is_login = $('#login_check').val();
                    if(is_login == 1){
                        addToWishlist(product_id,seller_id, type);
                    }else{
                        toastr.warning("{{__('defaultTheme.please_login_first')}}","{{__('common.warning')}}");
                    }
                });

                $(document).on('change', '.getFilterUpdateByIndex', function(event){

                    var paginate = $('#paginate_by').val();
                    var prev_stat = $('.filterCatCol').val();
                    var sort_by = $('#product_short_list').val();
                    var requestItem = $('#item_request').val();
                    var requestItemType = $('#item_request_type').val();
                    $('#pre-loader').show();
                    $.get("{{ route('frontend.sort_product_filter_by_type') }}", {paginate:paginate, sort_by:sort_by, requestItem:requestItem, requestItemType:requestItemType}, function(data){
                        $('#dataWithPaginate').html(data);
                        $('#product_short_list').niceSelect();
                        $('#paginate_by').niceSelect();
                        $('#pre-loader').hide();
                        $('.filterCatCol').val(prev_stat);
                    });
                });


                let minimum_price = 0;
                let maximum_price = 0;
                let price_range_gloval = 0;


                $(document).on('change', '#min_price', function(event){
                   let min = $(this).val();
                   let max = $('#max_price').val();
                   let price_range_glova1 = [min,max];
                    getProductByChoice("price_range",price_range_glova1);


                });
                $(document).on('change', '#max_price', function(event){
                     let max = $(this).val();
                   let min = $('#min_price').val();
                   let price_range_glova1 = [min,max];
                    getProductByChoice("price_range",price_range_glova1);
                });

                $(document).on('change', '.js-range-slider-0', function(event){
                    var price_range = $(this).val().split(';');
                    minimum_price = price_range[0];
                    maximum_price = price_range[1];
                    price_range_gloval = price_range;
                    myEfficientFn();
                });
                var myEfficientFn = debounce(function() {
                    $('#min_price').val(minimum_price);
                    $('#max_price').val(maximum_price);
                    console.log(price_range_gloval,"price_range_glovalprice_range_gloval");
                    getProductByChoice("price_range",price_range_gloval);
                }, 500);
                function debounce(func, wait, immediate) {
                    var timeout;
                    return function() {
                        var context = this, args = arguments;
                        var later = function() {
                            timeout = null;
                            if (!immediate) func.apply(context, args);
                        };
                        var callNow = immediate && !timeout;
                        clearTimeout(timeout);
                        timeout = setTimeout(later, wait);
                        if (callNow) func.apply(context, args);
                    };
                };
                $(".js-range-slider-0").ionRangeSlider({
                    type: "double",
                    min: $('#min_price').val(),
                    max: $('#max_price').val(),
                    from: $('#min_price').val(),
                    to: $('#max_price').val(),
                    drag_interval: true,
                    min_interval: null,
                    max_interval: null
                });

                function fetch_data(page){
                    $('#pre-loader').show();
                    if(page != 'undefined'){
                        var paginate = $('#paginate_by').val();
                        var sort_by = $('#product_short_list').val();
                        if (sort_by != null && paginate != null) {
                            var url = window.location.href+'&sort_by='+sort_by+'&paginate='+paginate+'&page='+page;
                        }else if (sort_by == null && paginate != null) {
                            var url = window.location.href+'&paginate='+paginate+'&page='+page;
                        }else {
                            var url = window.location.href+'&page='+page;
                        }
                        $.ajax({
                            url: url,
                            success:function(data)
                            {
                                $('#dataWithPaginate').html(data);
                                $('#product_short_list').niceSelect();
                                $('#paginate_by').niceSelect();
                                $('#pre-loader').hide();
                            }
                        });
                    }else{
                        toastr.warning("{{__('defaultTheme.this_is_undefined')}}","{{__('common.warning')}}");
                    }

                }

                function fetch_filter_data(page){
                    $('#pre-loader').show();
                    var paginate = $('#paginate_by').val();
                    var sort_by = $('#product_short_list').val();
                    var requestItem = $('#item_request').val();
                    var requestItemType = $('#item_request_type').val();
                    if (sort_by != null && paginate != null) {
                        var url = "{{route('frontend.product_filter_page_by_type')}}"+'?requestItem='+requestItem+'&requestItemType='+requestItemType+'&sort_by='+sort_by+'&paginate='+paginate+'&page='+page;
                    }else if (sort_by == null && paginate != null) {
                        var url = "{{route('frontend.product_filter_page_by_type')}}"+'?requestItem='+requestItem+'&requestItemType='+requestItemType+'&paginate='+paginate+'&page='+page;
                    }else {
                        var url = "{{route('frontend.product_filter_page_by_type')}}"+'?requestItem='+requestItem+'&requestItemType='+requestItemType+'&page='+page;
                    }
                    if(page != 'undefined'){
                        $.ajax({
                            url:url,
                            success:function(data)
                            {
                                $('#dataWithPaginate').html(data);
                                $('#product_short_list').niceSelect();
                                $('#paginate_by').niceSelect();
                                $('.filterCatCol').val(1);
                                $('#pre-loader').hide();
                            }
                        });
                    }else{
                        toastr.warning("{{__('defaultTheme.this_is_undefined')}}","{{__('common.warning')}}");
                    }
                }

                function getProductByChoice(type,el,checked=true)
                { 

                 
                    var requestItem = $('#item_request').val();
                
                    var requestItemType = $('#item_request_type').val();
                  
                    // var objNew = {filterTypeId:type, filterTypeValue:[el]};
                    // var objExistIndex = filterType.findIndex((objData) => objData.filterTypeId === type );



                    // if (objExistIndex < 0) {
                    //              filterType.push(objNew);
                    // }else {
                    //     var objExist = filterType[objExistIndex];

                    //     if (objExist && objExist.filterTypeId == "price_range") {
                    //         objExist.filterTypeValue.pop(el);
                    //     }
                    //     if (objExist && objExist.filterTypeId == "rating") {
                    //         objExist.filterTypeValue.pop(el);
                    //     }
                    //     if (objExist.filterTypeValue.includes(el)) {
                    //         objExist.filterTypeValue.pop(el);
                    //     }else {
                    //         objExist.filterTypeValue.push(el);
                    //     }
                       
                    // }
                    let filters = [];

                      $('.getProductByChoice').each(function(i){


                             if ($(this).is(':checked')) {
                                type = $(this).attr('data-id');
                                el = $(this).attr('data-value');
                                    console.log(el)
                                      var objNew = {filterTypeId:type, filterTypeValue:[el]};
                                    var objExistIndex = filters.findIndex((objData) => objData.filterTypeId === type );
                                     

                                        if (objExistIndex < 0) {
                                                     filters.push(objNew);
                                        }else {
                                            var objExist = filters[objExistIndex];
                                            console.log(filters,type)
                                             if (objExist.filterTypeValue.includes(el)) {
                                                // objExist.filterTypeValue.pop(el);
                                            }else {
                                                objExist.filterTypeValue.push(el);
                                            }

                                            // if (objExist && objExist.filterTypeId == "price_range") {
                                            //     objExist.filterTypeValue.pop(el);
                                            // }
                                            // if (objExist && objExist.filterTypeId == "rating") {
                                            //     objExist.filterTypeValue.pop(el);
                                            // }
                                            // if (objExist.filterTypeValue.includes(el)) {
                                            //     objExist.filterTypeValue.pop(el);
                                            // }else {
                                            //     objExist.filterTypeValue.push(el);
                                            // }
                                           
                                        }

                             }
                                
                            });

                      let max_price_filter = $('#max_price').val();
                      let min_price_filter = $('#min_price').val();

                      if(min_price_filter > 0 && max_price_filter > 0){
                                var objNew = {filterTypeId:'price_range', filterTypeValue:[min_price_filter,max_price_filter]};
                                  filters.push(objNew);
                      }

                    console.log(filters)
                    $('#pre-loader').show();
                    $.post('{{ route('frontend.product_filter_by_type') }}', {_token:'{{ csrf_token() }}', filterType:filters, requestItem:requestItem, requestItemType:requestItemType}, function(data){
                        $('#dataWithPaginate').html(data);
                        $('.filterCatCol').val(1);
                        $('#product_short_list').niceSelect();
                        $('#paginate_by').niceSelect();
                        $('#pre-loader').hide();
                    });
                }
            });
        })(jQuery);

    </script>
@endpush
