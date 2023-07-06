@php
    $actual_link = \Illuminate\Support\Facades\URL::current();
    $base_url = url('/');
    $new_user_zone = \Modules\Marketing\Entities\NewUserZone::where('status', 1)->first();
@endphp
<style type="text/css">
    .dashboard{
      margin-left: 20px;
      color: black;
    }
    .dash-link{
      margin-left: 250px;
    }
    .decoration{
      text-decoration: none;
    }

/* Dropdown */

.dropdown {
  display: inline-block;
  position: relative;
}

.dd-button {
  display: inline-block;
  border: 1px solid gray;
  border-radius: 4px;
  padding: 10px 30px 10px 20px;
  background-color: #ffffff;
  cursor: pointer;
  white-space: nowrap;
}

.dd-button:after {
  content: '';
  position: absolute;
  top: 50%;
  right: 15px;
  transform: translateY(-50%);
  width: 0; 
  height: 0; 
  border-left: 5px solid transparent;
  border-right: 5px solid transparent;
  border-top: 5px solid black;
}

.dd-button:hover {
  background-color: #eeeeee;
}


.dd-input {
  display: none;
}

.dd-menu {
  position: absolute;
  top: 100%;
  border: 1px solid #ccc;
  border-radius: 4px;
  padding: 0;
  margin: 2px 0 0 0;
  box-shadow: 0 0 6px 0 rgba(0,0,0,0.1);
  background-color: #ffffff;
  list-style-type: none;
}

.dd-input + .dd-menu {
  display: none;
} 

.dd-input:checked + .dd-menu {
  display: block;
} 

.dd-menu li {
  padding: 10px 20px;
  cursor: pointer;
  white-space: nowrap;
}

.dd-menu li:hover {
  background-color: #f6f6f6;
}

.dd-menu li a {
  display: block;
  margin: -10px -20px;
  padding: 10px 20px;
}

.dd-menu li.divider{
  padding: 0;
  border-bottom: 1px solid #cccccc;
}

.desktop-navbar{
  margin: 0 0 0 3.5%;
}
</style>

@php 
$menus  = \Modules\Menu\Entities\Menu::whereIn('menu_type',['mega_menu','normal_menu'])->with('allElements')->get();
$categories = \Modules\Product\Entities\Category::with('subCategories')->get();
$brands = \Modules\Product\Entities\Brand::get();
@endphp

@if($menus->count()) 


<nav class="navbar navbar-expand-lg navbar-dark mymega-menu align-itmes-center">
    <a class="logo_main" href="{{ url('/') }}"><img src="{{asset('images/icons/centoria_logo.png')}}" class="img-fluid" alt="" }></h2></a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
    <i class="bi bi-list"></i>
  </button>
  <div class="collapse navbar-collapse" id="navbarText">
    <ul class="navbar-nav mr-auto desktop-navbar">
    @foreach($menus as $key => $menu)
    @if(@$menu->menu_type == 'mega_menu' && @$menu->status == 1)

      <li class="nav-item  dropdown"> 
        <a class="nav-link botomline dropdown-toggle" href="/{{$menu->slug}}" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        {{ \Illuminate\Support\Str::limit($menu->name, 25, $end='...') }} <i class="bi bi-chevron-down d-lg-none d-sm-block d-md-blcok mobile_iocn"></i>
        </a>
        <div class="dropdown-menu listmenuitem" aria-labelledby="navbarDropdown">
         
          @if(count($menu->allElements) > 0)
          
          
             @if(@$menu->menu_type == 'mega_menu' && @$menu->status == 1)
             
             
             @foreach($menu->allElements as $key => $column)

                <ul class="nav flex-column">
                @if($column->type == 'category')
                <li class="nav-item">
                  <a class="nav-link" href="{{url('category/'.$column->category->slug.'?item=category')}}">{{ \Illuminate\Support\Str::limit($column->title, 25, $end='...') }} </a>
                </li>
                @elseif($column->type == 'brand')

                <li class="nav-item">
                  <a class="nav-link" href="{{url('category/'.$column->brand->slug.'?item=brand')}}">{{ \Illuminate\Support\Str::limit($column->title, 25, $end='...') }}</a>
                </li>
                @elseif($column->type == 'page')
                <li class="nav-item">
                  <a class="nav-link" href="{{url($column->page->slug)}}">{{ \Illuminate\Support\Str::limit($column->title, 25, $end='...') }}</a> 
                </li>
                @else
                 <li class="nav-item"><a class="nav-link" href="{{url('/'.$column->link)}}">{{ \Illuminate\Support\Str::limit($column->title, 25, $end='...') }}</a></li>
                @endif
                @endforeach
              </ul>
            @endif 
          @endif 
        </div>
      </li>
      @else
        <li class="nav-item "><a href="{{$menu->slug}}" class="nav-link botomline"> {{ \Illuminate\Support\Str::limit($menu->name, 25, $end='...') }}</a></li>
      @endif
    @endforeach
    <!-- <a href="{{route('frontend.cart')}}" class="nav-link"><i class="bi bi-cart-dash"></i></a> -->
{{-- <label class="dropdown">
  <div class="dd-button">
    Dropdown
  </div>
  <input type="checkbox" class="dd-input" id="test">
  <ul class="dd-menu">
    <li>Action</li>
    <li>Another action</li>
    <li>Something else here</li>
    <li class="divider"></li>
    <li>
      <a href="http://rane.io">Link to Rane.io</a>
    </li>
  </ul>
</label> --}}
        {{-- <li class="nav-item"><a href="{{url('/blog')}}" class="nav-link">Blog</a></li>
        <li class="nav-item"><a href="{{url('/enquiry')}}" class="nav-link">Enquiry</a></li> --}}
    </ul>
    <form class="form-inline bgcolor_from mr-auto" action="{{url('/search')}}">
      <a class=" my-2 my-sm-0" type="submit"><i class="bi bi-search"></i></a   >
      <input class="form-control" type="text" id="search" placeholder="Search for products ..." aria-label="Search">
      <div id="header_result" style="position: absolute;font-size: 14px; padding-top:150px; min-height: 200px; overflow: auto; z-index: 999;"></div>
    </form>
  </div>
  <div class="account_btn">
<div class="right_sub_menu">
    <ul>
      <li>
      <div class="dropdown profillist_setting">
        <a id="dropdownMenuLink" class='dropdown-toggle' href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <i class="bi bi-person-circle"></i>
          <h5>Profile</h5>
        </a>
        
        <div class="dropdown-menu settingmeni" aria-labelledby="dropdownMenuLink">
          @guest
          <a href="{{ url('/register') }}" class="dropdown-item desktop-linkButton">Signup</a>
          <a class="dropdown-item" href="{{ url('/login') }}">Login </a>
          @else
          <a class="dropdown-item">
            <span class="mr-4"> Hello {{ auth()->user()->first_name }}</span> <br>
            <span class="mr-4">  {{ auth()->user()->phone }}</span>
          </a>
          <a class="dropdown-item" href="{{ route('frontend.my_purchase_order_list') }}">Order History </a>
          <a class="dropdown-item" href="{{ route('frontend.my-wishlist') }}">Wishlist</a>
          <a class="dropdown-item" href="{{ url('/profile') }}">Edit profile </a>
          <a class="dropdown-item" href="{{ route('referral-code') }}">My Referral Code </a>
          <a class="dropdown-item log_out" href="{{ route('logout') }}">Logout </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
              @csrf
            </form>
        @endguest
        </div>
      </div>
      </li>
    @auth
    <li>
        <a href="{{ route('frontend.my-wishlist') }}"><i class="bi bi-heart"></i> 
        <h5>Wishlist</h5>
      </a>
    </li>
    @endauth
    <li class="position-relative cartnumber">
      @auth<span class="cart-count" id="cart_count_bottom"></span>@endauth
        <a href="{{route('frontend.cart')}}"><i class="bi bi-bag "></i>
        <h5>Cart</h5>
      </a>
    </li>
    <!-- @guest
    <div class="account_btn">
        <a href="{{ url('/register') }}" style="text-decoration: none; color: black;" class="sing_up decoration">{{ __('defaultTheme.sign_up') }}</a>&nbsp;&nbsp;&nbsp;&nbsp;
        <a href="{{ url('/login') }}" style="text-decoration: none; color: black;" class="login decoration">{{ __('defaultTheme.login') }}</a>
    </div>
    @else
    <div class="dropdown pt-2">
        <a class=" dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Setting <i class="fa fa-user" aria-hidden="true"></i></a>
<div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
    <div class="account_btn">
    <p class="dashboard">hello! <span>{{ substr(auth()->user()->first_name,0,25) }}
    @if(strlen(auth()->user()->first_name) > 25)... @endif</span></p>
    </div>
    <a class="dropdown-item" href="{{ route('frontend.dashboard') }}"><i class="ti-dashboard"></i> {{ __('common.dashboard') }}</a>
    {{-- <a class="dropdown-item " href="{{ route('frontend.my_purchase_order_list') }}"> <i class="ti-shopping-cart-full"></i> {{ __('order.my_order') }}</a>
    <a class="dropdown-item" href="{{ route('frontend.purchased-gift-card') }}"><i class="ti-shopping-cart-full"></i> {{ __('customer_panel.gift_card') }}</a>
    <a class="dropdown-item " href="{{ url('/profile') }}"><i class="ti-user"></i> {{__('customer_panel.my_account') }}</a>
    <a class="dropdown-item " href="{{ route('refund.frontend.index') }}"><i class="ti-reload"></i> {{__('customer_panel.refund_dispute') }}</a>
    <a class="dropdown-item " href="{{route('my-wallet.index', 'customer')}}"><i class="ti-wallet"></i> {{__('wallet.my_wallet') }}</a>
    <a class="dropdown-item " href="{{url('/support-ticket')}}"><i class="ti-headphone-alt"></i> {{__('ticket.support_ticket') }}</a>
    <a  class="dropdown-item" href="{{ route('frontend.digital_product') }}"><i class="ti-shopping-cart-full"></i> {{ __('customer_panel.digital_product') }}</a>
    <a class="dropdown-item" href="{{ route('frontend.my-wishlist') }}"><i class="ti-heart"></i> {{ __('customer_panel.my_wishlist') }}</a>
    <a class="dropdown-item" href="{{ url('/profile/coupons') }}"><i class="ti-receipt"></i> {{__('customer_panel.my_coupon') }}</a> --}}

    <a href="{{ route('logout') }}" class="log_out"><i class="ti-shift-right dashboard"></i> {{ __('defaultTheme.log_out') }} </a>
    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
    @csrf
    </form>
  </div>
</div>
@endguest -->
</ul>
</div>
</div>
</nav>
@endif




<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.4.24/dist/sweetalert2.all.min.js"  referrerpolicy="no-referrer"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>

<script>
  $(document).ready(function(){
    
    loadCart();

    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    })

    function loadCart()
    {
      $.ajax({
        method : "GET",
        url : "/load-cart-data",
        data : "data",
        datatype : "datatype",
        success : function (response){
          $('.cart-count').html('');
          $('.cart-count').html(response.count);
          console.log(response.count);
        }
      })
    }
  })

</script>

<script>
  $('#search').keyup(function(e) {
    let q = $(this).val();
    console.log(q.length)
    if (q.length > 0) {
      $.ajax({
        type: "get",
        url: "{{url('/search')}}/" + q,
          success: function(data) {
          $('#header_result').html(data);
        }
      });
    } else {
    $('#header_result').html('');
    return false;
    }
  });

    $(() => {
        $('#scrollUp').fadeOut();
        $(window).scroll(() => {
            if ($(this).scrollTop() > 250) {
              $('#scrollUp').fadeIn();
            } else {
              $('#scrollUp').fadeOut();
            }
        });
    });
    $("#scrollUp").click(() => {
      $(document).scrollTop(0);
    });


let searchInput = document.getElementById("search");
// console.log(searchInput)
  searchInput.addEventListener("keypress", function(event) {
  if (event.key === "Enter") {
    event.preventDefault();
    document.getElementById("search-form").submit();
  }
});


</script>
