@extends('frontend.default.layouts.app')
@section('content')

<div class="aboutimgbg-top">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <h3>Blog Details</h3>
            </div>
        </div>
    </div>
</div>

<div class="pages-details pt-50 pb-50">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="text-center mb-5 mt-5">
                        <img src="{{isset($post->image_url)? showImage($post->image_url):showImage('backend/img/default.png')}}" alt="#">
                    </div>
                <div class="blog_details_section">
                {!! $post->content !!}
                </div>
            </div>
            
        </div>
    </div>
</div>

@endsection