<!DOCTYPE html>
<html lang="en" @if(isRtl()) dir="rtl" class="rtl" @else @endif>
  @include('frontend.default.partials._head',$popupContent)

  <body>
    <div class=" preloader_setup" id="pre-loader">
     {{--  @include('backEnd.partials.preloader') --}}
    </div>
    <input type="hidden" id="url" value="{{url('/')}}">
    @php
        $base_url = url('/');
        $current_url = url()->current();
        $just_path = trim(str_replace($base_url,'',$current_url));
    @endphp
  <input type="hidden" id="just_url" value="{{$just_path}}">
  <header class="header_part single_page_menu_item home_page_menu">

  @include('frontend.default.partials._mainmenu') 
  @include('frontend.default.partials._submenu')
  </header>
