<div class="white_box_50px box_shadow_white mb-40 min-height-430">
    <form action="POST" id="add_element_form">
        <div class="row">
            <input type="hidden" name="id" value="{{$header->id}}">
            <input type="hidden" id="create_header_type" value="{{$header->type}}">
            @if($type == 'category')
            <div class="col-lg-12">
                <div class="primary_input mb-25">
                    <label class="primary_input_label" for="">{{ __('common.category_list') }}</label>
                    <select name="category[]" id="category" class="category mb-15" multiple>

                    </select>
                    <span class="text-danger"></span>
                </div>
            </div>
            
            @elseif($type == 'slider')
            <div class="col-lg-12">
                <div class="primary_input mb-25">
                        <label class="primary_input_label"
                            for="name">{{__('common.name')}} <span class="text-danger">*</span></label>
                            <input class="primary_input_field" type="text" id="name" name="name" autocomplete="off"
                        value="" placeholder="{{__('common.name')}}">
                </div>
                <span class="text-danger" id="error_name"></span>
            </div>
            <div class="col-lg-12" id="slider_data_type_div">
                <div class="primary_input mb-25">
                    <label class="primary_input_label" for="">{{ __('appearance.slider_for') }}</label>
                    <select name="data_type" id="slider_for" class="primary_select mb-15">
                        <option value="" selected disabled>{{ __('common.select_one') }}</option>
                        <option value="product">{{ __('appearance.for_product') }}</option>
                        <option value="category">{{ __('appearance.for_category') }}</option>
                        <option value="brand">{{ __('appearance.for_brand') }}</option>
                        <option value="tag">{{ __('appearance.for_tag') }}</option>
                        <option value="url">{{ __('appearance.for_url_not_support_in_mobile_app') }}</option>
                    </select>
                    <span class="text-danger" id="error_slider_data_type"></span>
                </div>
            </div>
            <div class="col-lg-12" id="slider_for_data_div">
            </div>
            <div id="sliderImgFileDiv" class="col-lg-8">
                <div class="primary_input mb-25">
                    <label class="primary_input_label" for="">{{ __('appearance.slider_image') }} (660 x 365)PX <span class="text-danger">*</span></label>
                    <div class="primary_file_uploader">
                        <input class="primary-input" type="text" id="banner_image_file"
                            placeholder="{{__('common.browse')}} {{__('common.image')}}" readonly="">
                        <button class="" type="button">
                            <label class="primary-btn small fix-gr-bg"
                                for="slider_image">{{ __('common.browse') }} </label>
                            <input type="file" class="d-none" name="slider_image" id="slider_image">
                        </button>
                    </div>
                </div>

                <span class="text-danger" id="error_slider_image"></span>
            </div>
            <div class="col-lg-4">
                <div id="createSliderImgDiv">
                    <img id="MetaImgDiv"
                    src="{{ showImage('backend/img/default.png') }}" alt="">
                </div>
            </div>
            <div class="col-lg-12">
                <div class="primary_input">
                    <label class="primary_input_label" for="">{{ __('common.status') }}</label>
                    <ul id="theme_nav" class="permission_list sms_list ">
                        <li>
                            <label data-id="bg_option" class="primary_checkbox d-flex mr-12">
                                <input name="status" id="status_active" value="1" checked="true" class="active"
                                    type="radio">
                                <span class="checkmark"></span>
                            </label>
                            <p>{{ __('common.active') }}</p>
                        </li>
                        <li>
                            <label data-id="color_option" class="primary_checkbox d-flex mr-12">
                                <input name="status" value="0" id="status_inactive" class="de_active" type="radio">
                                <span class="checkmark"></span>
                            </label>
                            <p>{{ __('common.inactive') }}</p>
                        </li>
                    </ul>
                    <span class="text-danger" id="status_error"></span>
                </div>
            </div>
            <div class="col-xl-12">
                <div class="primary_input">
                    <ul id="theme_nav" class="permission_list sms_list ">
                        <li>
                            <label data-id="bg_option" class="primary_checkbox d-flex mr-12">
                                <input name="is_newtab" id="is_newtab" value="1" checked type="checkbox">
                                <span class="checkmark"></span>
                            </label>
                            <p>{{ __('common.open_link_in_a_new_tab') }}</p>
                        </li>
                    </ul>
                </div>
            </div>

            @elseif($type == 'offer_collection')
            <div class="col-lg-12">
                <div class="primary_input mb-25">
                        <label class="primary_input_label"
                            for="name">{{__('common.title')}} <span class="text-danger">*</span></label>
                            <input class="primary_input_field" type="text" id="name" name="name" autocomplete="off"
                        value="" placeholder="{{__('common.title')}}">
                </div>
                <span class="text-danger" id="error_name"></span>
            </div>
            <div class="col-lg-12">
                <div class="primary_input mb-25">
                <h3 class="mb-3 mr-30">{{ __('common.description') }}</h3>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="primary_input mb-15">
                    <textarea  name="description" class="ckeditor" placeholder="{{__('common.offer_description')}}"> {{old('description')}}</textarea>
                </div>
            </div>

            <div class="col-lg-12">
                <div class="primary_input mb-25">
                        <label class="primary_input_label"
                            for="name">{{__('url')}} <span class="text-danger">*</span></label>
                            <input class="primary_input_field" type="text" id="url" name="url" autocomplete="off"
                        value="" placeholder="{{__('url')}}">
                </div>
                <span class="text-danger" id="error_name"></span>
            </div>
            
            <div class="col-lg-12" id="offerCollection_for_data_div">
            </div>
            <div id="offerCollectionImgFileDiv" class="col-lg-8">
                <div class="primary_input mb-25">
                    <label class="primary_input_label" for="">{{ __('appearance.offer_image') }} (660 x 365)PX <span class="text-danger">*</span></label>
                    <div class="primary_file_uploader">
                        <input class="primary-input" type="text" id="banner_image_file"
                            placeholder="{{__('common.browse')}} {{__('common.image')}}" readonly="">
                        <button class="" type="button">
                            <label class="primary-btn small fix-gr-bg"
                                for="offer_image">{{ __('common.browse') }} </label>
                            <input type="file" class="d-none" name="offer_image" id="offer_image">
                        </button>
                    </div>
                </div>

                <span class="text-danger" id="error_offerCollection_image"></span>
            </div>
            <div class="col-lg-4">
                <div id="createOfferCollectionImgDiv">
                    <img id="MetaImgDiv"
                    src="{{ showImage('backend/img/default.png') }}" alt="">
                </div>
            </div>
            <div class="col-lg-12">
                <div class="primary_input">
                    <label class="primary_input_label" for="">{{ __('common.status') }}</label>
                    <ul id="theme_nav" class="permission_list sms_list ">
                        <li>
                            <label data-id="bg_option" class="primary_checkbox d-flex mr-12">
                                <input name="status" id="status_active" value="1" checked="true" class="active"
                                    type="radio">
                                <span class="checkmark"></span>
                            </label>
                            <p>{{ __('common.active') }}</p>
                        </li>
                        <li>
                            <label data-id="color_option" class="primary_checkbox d-flex mr-12">
                                <input name="status" value="0" id="status_inactive" class="de_active" type="radio">
                                <span class="checkmark"></span>
                            </label>
                            <p>{{ __('common.inactive') }}</p>
                        </li>
                    </ul>
                    <span class="text-danger" id="status_error"></span>
                </div>
            </div>
            <div class="col-xl-12">
                <div class="primary_input">
                    <ul id="theme_nav" class="permission_list sms_list ">
                        <li>
                            <label data-id="bg_option" class="primary_checkbox d-flex mr-12">
                                <input name="is_newtab" id="is_newtab" value="1" checked type="checkbox">
                                <span class="checkmark"></span>
                            </label>
                            <p>{{ __('common.open_link_in_a_new_tab') }}</p>
                        </li>
                    </ul>
                </div>
            </div>


            @elseif($type == 'clients')
            {{-- <div class="col-lg-12">
                <div class="primary_input mb-25">
                        <label class="primary_input_label"
                            for="name">{{__('common.title')}} <span class="text-danger">*</span></label>
                            <input class="primary_input_field" type="text" id="name" name="name" autocomplete="off"
                        value="" placeholder="{{__('common.title')}}">
                </div>
                <span class="text-danger" id="error_name"></span>
            </div> --}}
            {{-- <div class="col-lg-12">
                <div class="primary_input mb-25">
                <h3 class="mb-3 mr-30">{{ __('common.description') }}</h3>
                </div>
            </div> --}}
            {{-- <div class="col-lg-12">
                <div class="primary_input mb-15">
                    <textarea  name="description" class="ckeditor" placeholder="{{__('common.offer_description')}}"> {{old('description')}}</textarea>
                </div>
            </div> --}}
            {{-- <div class="col-lg-12" id="offerCollection_data_type_div">
                <div class="primary_input mb-25">
                    <label class="primary_input_label" for="">{{ __('appearance.offer_for') }}</label>
                    <select name="data_type" id="offer_for" class="primary_select mb-15">
                        <option value="" selected disabled>{{ __('common.select_one') }}</option>
                        <option value="product">{{ __('appearance.for_product') }}</option>
                        <option value="category">{{ __('appearance.for_category') }}</option>
                        <option value="brand">{{ __('appearance.for_brand') }}</option>
                        <option value="tag">{{ __('appearance.for_tag') }}</option>
                        <option value="url">{{ __('appearance.for_url_not_support_in_mobile_app') }}</option>
                    </select>
                    <span class="text-danger" id="error_offerCollection_data_type"></span>
                </div>
            </div> --}}
            {{-- <div class="col-lg-12" id="offerCollection_for_data_div">
            </div> --}}
            <div id="clientsImgFileDiv" class="col-lg-8">
                <div class="primary_input mb-25">
                    <label class="primary_input_label" for="">{{ __('appearance.clients_image') }} (660 x 365)PX <span class="text-danger">*</span></label>
                    <div class="primary_file_uploader">
                        <input class="primary-input" type="text" id="banner_image_file"
                            placeholder="{{__('common.browse')}} {{__('common.image')}}" readonly="">
                        <button class="" type="button">
                            <label class="primary-btn small fix-gr-bg"
                                for="clients_image">{{ __('common.browse') }} </label>
                            <input type="file" class="d-none" name="clients_image" id="clients_image">
                        </button>
                    </div>
                </div>

                <span class="text-danger" id="error_clients_image"></span>
            </div>
            <div class="col-lg-4">
                <div id="createClientsImgDiv">
                    <img id="MetaImgDiv"
                    src="{{ showImage('backend/img/default.png') }}" alt="">
                </div>
            </div>
            <div class="col-lg-12">
                <div class="primary_input">
                    <label class="primary_input_label" for="">{{ __('common.status') }}</label>
                    <ul id="theme_nav" class="permission_list sms_list ">
                        <li>
                            <label data-id="bg_option" class="primary_checkbox d-flex mr-12">
                                <input name="status" id="status_active" value="1" checked="true" class="active"
                                    type="radio">
                                <span class="checkmark"></span>
                            </label>
                            <p>{{ __('common.active') }}</p>
                        </li>
                        <li>
                            <label data-id="color_option" class="primary_checkbox d-flex mr-12">
                                <input name="status" value="0" id="status_inactive" class="de_active" type="radio">
                                <span class="checkmark"></span>
                            </label>
                            <p>{{ __('common.inactive') }}</p>
                        </li>
                    </ul>
                    <span class="text-danger" id="status_error"></span>
                </div>
            </div>
            {{-- <div class="col-xl-12">
                <div class="primary_input">
                    <ul id="theme_nav" class="permission_list sms_list ">
                        <li>
                            <label data-id="bg_option" class="primary_checkbox d-flex mr-12">
                                <input name="is_newtab" id="is_newtab" value="1" checked type="checkbox">
                                <span class="checkmark"></span>
                            </label>
                            <p>{{ __('common.open_link_in_a_new_tab') }}</p>
                        </li>
                    </ul>
                </div>
            </div> --}}

            @elseif($type == 'product')
            <div class="col-lg-12">
                <div class="primary_input mb-25">
                    <label class="primary_input_label" for="">{{ __('appearance.product_list') }}</label>
                    <select name="product[]" id="product" class=" product mb-15" multiple>

                    </select>
                    <span class="text-danger"></span>
                </div>
            </div>
            @endif
            <div class="col-xl-12 text-center">
                <button class="primary_btn_2 mt-5" id="widget_form_btn"><i
                        class="ti-check"></i>{{ __('common.save') }}
                </button>
            </div>
        </div>
    </form>
</div>
   
<script src="//cdn.ckeditor.com/4.14.0/standard/ckeditor.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
       $('ckeditor').ckeditor();
    });
</script>

