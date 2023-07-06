@extends('frontend.default.layouts.app')

@section('content')
<div class="aboutimgbg-top">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <h3>Blog</h3>
            </div>
        </div>
    </div>
</div>
<div class="blog_page pt-50 pb-50">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-7 text-center mb-4">
                <h2><strong> Our Recent Blog </strong></h2>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
                tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
                quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
                </p>
            </div>
        </div>
        <div class="row">
          @foreach($posts as $post)
            <div class="col-lg-4 col-sm-6 col-md-6">
                     <div class="blog_product_item">
                  <div class="blog_img">
                  <a href="#"> <img src="{{isset($post->image_url)? showImage($post->image_url):showImage('backend/img/default.png')}}" alt="#"></a>
                  </div>
                  <div class="blog_content">
                    <a href="#" class="in_category">{{$post->category->name??''}}</a>
                    <div class="time-conment">
                      <span class="post-date">
                       {{$post->created_at->format('d-m-Y')}}
                       </span>
                    </div>            
                    <h3 class="post-title"><a href="#">{{$post->title}}</a></h3>
                    <div class="short-des">{!! Str::limit($post->content, 200) !!}</div>
                    <div class="blog_button">
                      <a href="{{route('blog.single.page',$post->slug)}}" class="readmore">Read More <i class="fa fa-chevron-right"></i></a>
                    </div>
                  </div>
                </div>
            </div>

            @endforeach
        </div>
    </div>
</div>

@endsection