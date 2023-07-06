<!-- footer part -->
@php
$brands = \Modules\Product\Entities\Brand::get();
$menus  = \Modules\Menu\Entities\Menu::whereIn('menu_type',['mega_menu','normal_menu'])->with('allElements')->get();
@endphp

<div class="footer">
  <div class="container">
    <div class="row">
      <div class="col-lg-3 col-sm-6 col-md-6">
        <div class="footerheading">
          {{-- <h2>{{(app('general_setting')->system_logo_name) }}</h2> --}}
          <a class="logo_main" href="{{ url('/') }}"><img src="{{asset('images/icons/centoria_logo.png')}}" class="img-fluid" alt="" }></h2></a>
          <div class="socal_iocn">

            {{-- <ul>
              <li><a href="#"><i class="fa fa-facebook-square" aria-hidden="true"></i></a></li>
              <li><a href="#"><i class="fa fa-instagram" aria-hidden="true"></i></a></li>
              <li><a href="#"><i class="fa fa-twitter-square" aria-hidden="true"></i></a></li>
              <li><a href="#"><i class="fa fa-youtube-play" aria-hidden="true"></i></a></li>
            </ul> --}}
          </div>
        </div>
      </div>

      <div class="col-lg-3 col-sm-6 col-md-6">
         <div class="list_footer">
          <h4>Quick Links</h4>
           <ul style="display: block;">
               @foreach($sectionWidgets->where('section','1') as $page)
                    @if(!isModuleActive('Lead') && $page->pageData->module == 'Lead')
                        @continue
                    @endif
                    <li><a href="{{ url($page->pageData->slug) }}">{{$page->name}}</a></li>
                @endforeach
            </ul>        
        </div>
      </div>
    <div class="col-lg-3 col-sm-6 col-md-6">
        <div class="list_footer">
          <h4>{{ app('general_setting')->footer_section_two_title }}</h4>
           <ul style="display: block;">
               @foreach($sectionWidgets->where('section','2') as $page)
                    @if(!isModuleActive('Lead') && $page->pageData->module == 'Lead')
                        @continue
                    @endif
                    <li><a href="{{ url($page->pageData->slug) }}">{{$page->name}}</a></li>
                @endforeach
            </ul>        
        </div>
    </div>
    <div class="col-lg-3 col-sm-6 col-md-6">
        <div class="list_footer">
        <h4 class="list_footer">Top Brands</h4>
        @if($menus->count()) 
        @foreach($menus as $key => $menu)
            @if(@$menu->menu_type == 'mega_menu' && @$menu->status == 1)
              @if(count($menu->allElements) > 0)
                @if(@$menu->menu_type == 'mega_menu' && @$menu->status == 1)
                  @foreach($menu->allElements as $key => $column)
                    @if($column->type == 'brand')
                      <ul style="display: block;">
                        <li>
                        <a href="{{url('category/'.$column->brand->slug.'?item=brand')}}">{{ \Illuminate\Support\Str::limit($column->title, 25, $end='...') }}</a>
                        </li>
                      </ul>
                    @endif
                  @endforeach
                @endif 
              @endif
            @endif   
          @endforeach
        @endif  
        </div>
      </div>
    {{-- <div class="col-lg-3 col-sm-6 col-md-6">
        <div class="footer-links footer-contact">
            <h4>{{ app('general_setting')->footer_about_title }}</h4>
            <p>@php echo app('general_setting')->footer_about_description; @endphp</p>
        </div>
    </div> --}}
</div>
</div>
</div>
<div class="footer-bottom">
   <div class="single_footer_content copy_r_mt ">
        <div class="copyright_text">
        <p>
        @php echo app('general_setting')->footer_copy_right; @endphp
       </p>
        </div>
    </div>
</div>


<script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
<!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js"></script> -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script> 
<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
<!-- <script src="https://jacoblett.github.io/bootstrap4-latest/bootstrap-4-latest.min.js"></script> -->

<script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.js"></script>
<script type="text/javascript" src="{{asset('frontend/default/js/vgnav.min.js')}}"></script>
<script type="text/javascript" src="{{asset('frontend/default/js/jquery.nivo.slider.js')}}"></script> 
<!-- <script type="text/javascript" src="{{asset('frontend/default/js/zoom-image.js')}}"></script>  -->
<script type="text/javascript" src="{{asset('frontend/default/js/main.js')}}"></script> 

<script>
    $('.js-anchor-link').click(function(e){
  e.preventDefault();
  var target = $($(this).attr('href'));
  if(target.length){
    var scrollTo = target.offset().top;
    $('body, html').animate({scrollTop: scrollTo+'px'}, 800);
  }
});




$('.show-reviews.owl-carousel').owlCarousel({
    loop:true,
    margin:20,
    nav:true,
    smartSpeed: 1500,
    navText: ['<i class="bi bi-chevron-left"></i>', '<i class="bi bi-chevron-right"></i>'],
    responsive:{
        0:{
            items:1
        },
        600:{
            items:3
        },
        1000:{
            items:5
        }
    }
})
</script>


<script>
    $('.product_item.owl-carousel').owlCarousel({
    loop:true,
    margin:10,
    nav:true,
    smartSpeed: 1500,
     autoplayTimeout: 4000,
    navText: ['<i class="bi bi-chevron-left"></i>', '<i class="bi bi-chevron-right"></i>'],
    responsive:{
        0:{
            items:1
        },
        600:{
            items:2
        },
        1000:{
            items:6
        }
    }
});

$('.blog_section.owl-carousel').owlCarousel({
    loop:true,
    margin:15,
    nav:true,
    smartSpeed: 1500,
     autoplayTimeout: 4000,
    navText: ['<i class="bi bi-chevron-left"></i>', '<i class="bi bi-chevron-right"></i>'],
    responsive:{
        0:{
            items:1
        },
        600:{
            items:3
        },
        1000:{
            items:3
        }
    }
});

$('.brandsection.owl-carousel').owlCarousel({
    loop:true,
    margin:10,
    autoplay:true,
    autoplayTimeout:1500,
      smartSpeed: 1500,
    nav:false,

    responsive:{
        0:{
            items:1
        },
        600:{
            items:3
        },
        1000:{
            items:5
        }
    }
});
$('.recentprduct.owl-carousel').owlCarousel({
    loop:true,
    margin:10,
    autoplay:false,
    autoplayTimeout:1500,
      smartSpeed: 1500,
    nav:false,
    navText: ['<i class="bi bi-chevron-left"></i>', '<i class="bi bi-chevron-right"></i>'],
    responsive:{
        0:{
            items:1
        },
        600:{
            items:3
        },
        1000:{
            items:5
        }
    }
})
</script>

<script>
$(document).ready(function(){
  $("#showfrom").click(function(){
    $(".form_area").toggle();
  });
});
</script>

<script>
    $(document).ready(function () {
    $('.vg-nav').vegasMenu();
    })
</script>

<script>
$(document).ready(function(){
  $(".clickshare").click(function(){
    $(".socal_linkproduct").toggle();
  });
});


</script>

<script type="text/javascript">
    $(window).load(function() {
        $('#slider').nivoSlider();
    });    
</script> 
<script>
    $(function () {
  $('[data-toggle="tooltip"]').tooltip()
});

$(document).ready(function(){
  $(".edit_section_show").click(function(){
    $(".edit_section").show();
  });
});

</script>

<script>
$(document).ready(function(){
$('#modal_view_left').modal({
    show: 'false'
});

});
</script>
{{-- <div class="footer__sticky__menu">
    <a href="{{url('/')}}">
        <i class="ti-home"></i>
        <span>{{__('common.home')}}</span>
    </a>
    <a href="{{ url('/category') }}" class="lang_drawer_activator">
        <i class="ti-align-justify"></i>
        <span>{{__('common.category')}}</span>
    </a>
    <a href="{{ route('frontend.cart') }}">
        <span class="cart_count_phone">0</span>
        <i class="ti-shopping-cart"></i>
        <span>{{__('common.cart')}} (<span id="cart_count_bottom">{{$items}}</span>)</span>
    </a>
    @guest
    <a href="{{ url('/login') }}" class="account_drawer_activator">
        <i class="ti-user"></i>
        <span>{{ __('defaultTheme.login') }}/ {{__('defaultTheme.register')}}</span>
    </a>
    @else
    <a href="{{ route('frontend.dashboard') }}" class="account_drawer_activator">
        <i class="ti-user"></i>
        <span>{{__('common.account')}}</span>
    </a>
    @endguest
</div> --}}

{{-- facebook chat start
@php
    $messanger_data = \Modules\GeneralSetting\Entities\FacebookMessage::first();
@endphp
@if($messanger_data->status == 1)
    @php echo $messanger_data->code; @endphp
@endif
facebook chat end --}}

 @include('frontend.default.partials._script')

@stack('scripts')
@stack('wallet_scripts')
<script>
    $(document).ready(function(){
  $(".hideboxfrom").click(function(){
   alert('1')
  });
});
</script>
</body>

</html>




{{-- <footer class="footer_part">
    <div class="container">
        <div class="row justify-content-between pt-15 footer_reverce">
            <div class="col-lg-5">
                <div class="single_footer_content copy_r_mt ">
                    <h4>{{ app('general_setting')->footer_about_title }}</h4>
                    <p>@php echo app('general_setting')->footer_about_description; @endphp</p>
                    <div class="copyright_text">
                        <p>
                            @php echo app('general_setting')->footer_copy_right; @endphp
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="footer_content">
                    <div class="single_footer_content">
                        <h4>{{ app('general_setting')->footer_section_one_title }}</h4>
                        <ul>
                            @foreach($sectionWidgets->where('section','1') as $page)
                                @if(!isModuleActive('Lead') && $page->pageData->module == 'Lead')
                                    @continue
                                @endif
                                <li><a href="{{ url($page->pageData->slug) }}">{{$page->name}}</a></li>
                            @endforeach
                        </ul>
                    </div>
                    <div class="single_footer_content">
                        <h4>{{ app('general_setting')->footer_section_two_title }}</h4>
                        <ul>
                            @foreach($sectionWidgets->where('section','2') as $page)
                                @if(!isModuleActive('Lead') && $page->pageData->module == 'Lead')
                                    @continue
                                @endif
                                <li><a href="{{ url($page->pageData->slug) }}">{{$page->name}}</a></li>
                            @endforeach
                        </ul>
                    </div>
                    <div class="single_footer_content">
                        <h4>{{ app('general_setting')->footer_section_three_title }}</h4>
                        <ul>
                            @foreach($sectionWidgets->where('section','3') as $page)
                                @if(!isModuleActive('Lead') && $page->pageData->module == 'Lead')
                                    @continue
                                @endif
                                <li><a href="{{ url($page->pageData->slug) }}">{{$page->name}}</a></li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer> --}}
  {{-- 1 st costomer servic --}}
{{-- <div class="single_footer_content">
                        <h4>{{ app('general_setting')->footer_section_two_title }}</h4>
                        <ul>
                            @foreach($sectionWidgets->where('section','2') as $page)
                                @if(!isModuleActive('Lead') && $page->pageData->module == 'Lead')
                                    @continue
                                @endif
                                <li><a href="{{ url($page->pageData->slug) }}">{{$page->name}}</a></li>
                            @endforeach
                        </ul>
                    </div> --}}