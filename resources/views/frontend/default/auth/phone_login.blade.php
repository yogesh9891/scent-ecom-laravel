@extends('frontend.default.layouts.app')
@section('styles')
    <style>
        .login_logo img {
            max-width: 140px;
            margin: 0 auto;
        }
        .register_part {
            background: var(--background_color) !important;
            min-height: 100vh !important;
        }
    </style>
@endsection
@section('content')
<section class="login_area register_part">
    <div class="container">
        <div class="row justify-content-center align-items-center">
            <div class="col-lg-6 col-xl-4">
                <div class="register_form_iner reset_pass">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            {{$errors->first()}}
                        </div>
                    @endif
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                   
                    <form method="POST" action="{{route('mobile-otp-send')}}">
                        @csrf
                        <div class="form-row">
                            <div class="col-md-12">
                                <h2 style="text-align:left" >Enter Your Mobile Number</h2>
                                <input type="text" id="text" class="form-control" maxlength="10" name="phone" placeholder="Enter Your Mobile Number" required >
                                @error('phone')
                                  <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                  </span>
                                @enderror
                            </div>

                            <div class="col-md-12 text-center">
                                <div class="register_area">
                                    <button type="submit" class="btn-full btn-link" style="margin: 15px 0">Submit</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
