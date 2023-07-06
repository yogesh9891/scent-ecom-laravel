@extends('backEnd.master')
@section('styles')

<link rel="stylesheet" href="{{asset(asset_path('modules/product/css/brand.css'))}}" />

@endsection
@section('mainContent')
    <section class="admin-visitor-area up_st_admin_visitor">
        <div class="container-fluid p-0">
            <div class="row">
                <div class="col-12">
                    <div class="box_header common_table_header">
                        <div class="main-title d-md-flex">
                            <h3 class="mb-0 mr-30 mb_xs_15px mb_sm_20px">{{ __('Gender List') }}</h3>
                            @if (permissionCheck('product.gender.create'))
                                <ul class="d-md-flex">
                                    <li><a class="primary-btn radius_30px mr-10 fix-gr-bg" href="{{route("product.gender.create")}}"><i class="ti-plus"></i>{{__('Add Gender')}}</a></li>
                                   {{--  @if (permissionCheck('product.bulk_gender_upload_page'))
                                        <li><a class="primary-btn radius_30px mr-10 fix-gr-bg" href="{{ route('product.bulk_gender_upload_page') }}"><i class="ti-plus"></i>{{ __('product.bulk_gender_upload') }}</a></li>
                                    @endif --}}

                                    {{-- @if (permissionCheck('product.csv_gender_download'))
                                        <li><a class="primary-btn radius_30px mr-10 fix-gr-bg" href="{{ route('product.csv_gender_download') }}"><i class="ti-download"></i>{{ __('product.gender_csv') }}</a></li>
                                    @endif --}}
                                </ul>
                            @endif
                        </div>
                        <div class="table_search d-md-none d-xl-block">
                            <div class="serach_field-area3">
                                <div class="search_inner">
                                    <form action="{{ route('product.gender.index') }}" method="get">
                                        <div class="search_field">
                                            <input type="text" placeholder="" name="keyword" id="keyword" placeholder="" @isset($keyword) value="{{ $keyword }}" @endisset>
                                        </div>
                                        <button type="submit"> <i class="ti-search"></i> </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="QA_section QA_section_heading_custom check_box_table">
                        <div class="QA_table ">
                            <!-- table-responsive -->
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                    <tr>
                                        <th width="10%" scope="col">{{ __('common.id') }}</th>
                                        <th  width="20%" scope="col">{{ __('common.name') }}</th>
                                        {{-- <th  width="20%" scope="col">{{ __('common.logo') }}</th> --}}
                                        <th  width="15%" scope="col">{{ __('common.status') }}</th>
                                        <th  width="15%" scope="col">{{ __('common.featured') }}</th>
                                        <th  width="20%" scope="col">{{ __('common.action') }}</th>
                                    </tr>
                                    </thead>
                                    <tbody id="tablecontents">
                                    @foreach($genders as $key => $gender)
                                        <tr class="row1" data-id="{{ $gender->id }}">
                                            {{-- <th class="pl-3"><i class="fa fa-sort"></i></th> --}}
                                            <td>{{ $gender->id }}</td>
                                            <td>{{ $gender->name }}</td>
                                            {{-- <td>
                                                <div class="logo_div">
                                                    @if ($gender->logo != null)
                                                        <img src="{{showImage($gender->logo)}}" alt="{{$gender->name}}">
                                                    @else
                                                        <img src="{{showImage('frontend/default/img/gender_image.png')}}" alt="{{$gender->name}}">
                                                    @endif
                                                </div>
                                            </td> --}}
                                            <td>
                                                <label class="switch_toggle" for="checkbox{{ $gender->id }}">
                                                    <input type="checkbox" id="checkbox{{ $gender->id }}" @if ($gender->status == 1) checked @endif @if (permissionCheck('product.gender.update_active_status')) value="{{ $gender->id }}" data-id="{{$gender->id}}" class="status_change" @else disabled @endif>
                                                    <div class="slider round"></div>
                                                </label>
                                            </td>
                                            <td>
                                                <label class="switch_toggle" for="active_checkbox{{ $gender->id }}">
                                                    <input type="checkbox" id="active_checkbox{{ $gender->id }}" @if ($gender->featured == 1) checked @endif @if (permissionCheck('product.gender.update_active_feature')) value="{{ $gender->id }}" data-id="{{$gender->id}}" class="featured_change" @else disabled @endif>
                                                    <div class="slider round"></div>
                                                </label>
                                            </td>
                                            <td>
                                                <!-- shortby  -->
                                                <div class="dropdown CRM_dropdown">
                                                    <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenu2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                        {{ __('common.select') }}
                                                    </button>
                                                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenu2">
                                                        @if (permissionCheck('product.gender.edit'))
                                                            <a class="dropdown-item edit_gender" href="{{ route('product.gender.edit', $gender->id) }}">{{__('common.edit')}}</a>
                                                        @endif
                                                        @if (permissionCheck('product.gender.destroy'))
                                                            <a class="dropdown-item delete_gender" data-value="{{route('product.gender.destroy', $gender->id)}}">{{__('common.delete')}}</a>
                                                        @endif
                                                    </div>
                                                </div>
                                                <!-- shortby  -->
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="row justify-content-center mt-5">
                            <a href="javascript:void(0)"
                               class="primary-btn semi_large2 fix-gr-bg loadmore_btn">{{__('common.load_more')}}</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

@include('backEnd.partials.delete_modal',['item_name' => __('product.gender')])
@endsection
@push('scripts')
    <script type="text/javascript">

    (function($){
        "use strict";

        $(document).ready(function(){
            $(document).on('change', '.status_change', function(event){
                let id = $(this).data('id');
                let status = 0;

                if($(this).prop('checked')){
                    status = 1;
                }
                else{
                    status = 0;
                }

                $.post("{{ route('product.gender.update_active_status') }}", {_token:'{{ csrf_token() }}', id:id, status:status}, function(data){
                    if(data == 1){
                        toastr.success("{{__('common.updated_successfully')}}","{{__('common.success')}}");
                    }
                    else{
                        toastr.error("{{__('common.error_message')}}","{{__('common.error')}}");
                    }
                })
                .fail(function(response) {
                if(response.responseJSON.error){
                        toastr.error(response.responseJSON.error ,"{{__('common.error')}}");
                        $('#pre-loader').addClass('d-none');
                        return false;
                    }

                });
            });

            $(document).on('change', '.featured_change', function(event){
                let id = $(this).data('id');
                let featured = 0;

                if(this.checked){
                    featured = 1;
                }
                else{
                    featured = 0;
                }

                $.post('{{ route('product.gender.update_active_feature') }}', {_token:'{{ csrf_token() }}', id:id, featured:featured}, function(data){
                    if(data == 1){
                        toastr.success("{{__('common.updated_successfully')}}","{{__('common.success')}}");
                    }
                    else{
                        toastr.error("{{__('common.error_message')}}","{{__('common.error')}}");
                    }
                }).fail(function(response) {
                    if(response.responseJSON.error){
                        toastr.error(response.responseJSON.error ,"{{__('common.error')}}");
                        $('#pre-loader').addClass('d-none');
                        return false;
                    }

                });
            })

            $(function () {
                $("#table").DataTable();

                $( "#tablecontents" ).sortable({
                items: "tr",
                cursor: 'move',
                opacity: 0.6,
                update: function() {
                    sendOrderToServer();
                }
                });

                function sendOrderToServer() {
                var order = [];
                var token = $('meta[name="_token"]').attr('content');
                $('tr.row1').each(function(index,element) {
                    order.push({
                    id: $(this).attr('data-id'),
                    position: index+1
                    });
                });

                $.ajax({
                    type: "POST",
                    url: "{{ route('product.abc') }}",
                    data: {
                     order: order,
                    _token: token
                    },
                    success: function(response) {
                        if (response.status == "success") {
                        } 
                        else {
                        }
                    }
                });
                }
            });
            $(document).on('click', '.loadmore_btn', function () {
                var totalCurrentResult = $('#tablecontents tr').length;
                $("#pre-loader").removeClass('d-none');
                $.ajax({
                    url: "{{ route('product.load_more_genders') }}",
                    method: "POST",
                    data: {
                        skip: totalCurrentResult,
                        _token: "{{csrf_token()}}",
                    },
                    success: function (response) {
                        $("#tablecontents").append(response.genders);
                        $("#pre-loader").addClass('d-none');
                    },
                    error: function(response) {
                        $("#pre-loader").addClass('d-none');
                    }
                })
            });

            $(document).on('click', '.delete_gender', function(event){
                event.preventDefault();
                let route = $(this).data('value');
                confirm_modal(route);
            });

        });
    })(jQuery);


    </script>
@endpush
