@extends('frontend.default.layouts.app')

@section('breadcrumb')
{{ __('common.dashboard') }}
@endsection
@section('title')
{{ __('common.dashboard') }}
@endsection

@section('content')

@include('frontend.default.partials._breadcrumb')

<!--  dashboard part css here -->
<section class="dashboard_part bg-white padding_top">
    <div class="container">
        <div class="row">
            @include('frontend.default.pages.profile.partials._menu')


            <div class="col-xl-9 col-md-7">
                <div class="dashboard_item">
                    <div class="row">
                        
                          <div class="col-md-12">
                                      @if(auth()->user()->is_membership && auth()->user()->random_string)
                                            <h4>My Referral URL</h4>
                                            <p class="">
                                            {{url('/').'/membership-register/'.auth()->user()->random_string}}
                                        </p>
                                        @endif
                        </div>
                      {{--   <div class="col-md-6 col-xl-4">
                            <a href="{{ route('refund.frontend.index') }}">
                                <div class="single_dashboard_item wishlist">
                                    <i class="ti-shift-left"></i>
                                    <div class="single_dashboard_text">
                                        <h4>{{ $total_success_refund }}</h4>
                                        <p>{{ __('refund.refund_success') }}</p>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="col-md-6 col-xl-4">
                            <a href="{{url('/profile/coupons')}}">
                                <div class="single_dashboard_item disputes">
                                    <i class="ti-receipt"></i>
                                    <div class="single_dashboard_text">
                                        <h4>{{ $total_coupon_used }}</h4>
                                        <p>{{ __('common.total_coupon_used') }}</p>
                                    </div>
                                </div>
                            </a>
                        </div> --}}
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

@endsection
