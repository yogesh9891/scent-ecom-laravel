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
                    <!-- <div class="login_logo text-center mb-3">
                        <a href="{{url('/')}}"><img src="{{showImage(app('general_setting')->logo)}}" alt=""></a>
                    </div> -->

                    <h2 style="text-align:left">Reset Password</h2>
                    <p>Enter your email or mobile number and we’ll send a link on your email to reset your password.</p>
                    <form method="POST" class="register_form" action="{{ route('password.email') }}">
                        @csrf
                        <div class="form-row">
                            <div class="col-md-12">
                                <label for="email">Email Id</label>
                                <input type="email" id="email" name="email" placeholder="Enter your Email" required value="{{ old('email') }}" class="@error('email') is-invalid @enderror"
                                    onfocus="this.placeholder = ''"
                                    onblur="this.placeholder = ''">

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>



                            <div class="col-md-12 text-center">
                                <div class="register_area">
                                    <button type="submit" class="btn-full btn-link" id="submit_btn" style="margin: 15px 0">Submit</button>
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
