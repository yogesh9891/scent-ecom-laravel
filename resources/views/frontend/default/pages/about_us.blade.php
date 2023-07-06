@extends('frontend.default.layouts.app')

@section('title')
{{$content->mainTitle}}
@endsection
@section('breadcrumb')
    {{$content->mainTitle}}
@endsection

@section('styles')

<link rel="stylesheet" href="{{asset(asset_path('frontend/default/css/page_css/about_us.css'))}}" />

@endsection

@section('content')
{{-- 
@include('frontend.default.partials._breadcrumb')
 --}}
<div class="aboutimgbg-top">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <h3>About us</h3>
                </div>
            </div>
        </div>
    </div>
    <div class="about_pages pt-50  pb-50">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <h3>{{$content->subTitle}}</h3>
                    @php echo $content->mainDescription; @endphp
                </div>
                <div class="col-lg-4">
                    <div class="ab_right">
                        <img src="{{showImage($content->sec1_image)}}" alt="#" class="img-fluid">
                    </div>
                </div>
            </div>
        </div>
    </div>
<!-- about us part end -->

@endsection
