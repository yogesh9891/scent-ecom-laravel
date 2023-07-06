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
                    
                    <form method="POST" class="" action="{{ route('otp-compare') }}" id="verify-form">
                        @csrf
                        <div class="form-row">
                            <div class="col-md-12">
                                <span class="text-center" style="font-weight: bold; color:red" id="invalidOtp"></span>
                                <h2 style="text-align:left" >Otp send on your mobile {{$phone}} {{Session::get('phone')}} </h2>
                                <h2 style="text-align:left" >Enter Your Otp</h2>
                                <input type="hidden" name="phone" id="phone" value="{{$phone}}"/>
                                <input type="text" id="otp" name="otp" placeholder="Enter Your Otp" maxlength="6" required class="form-control">
                                <p class="pt-3" style="text-align:right; color:#ba933e; font-size:16px; font-weight:bold;" type="button" id="resendOtp">Resend Otp</p
                                @error('otp')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="col-md-12 text-center">
                                <div class="register_area">
                                    <button type="submit" class="btn-full btn-link" id="submitBtn" style="margin: 15px 0">Submit</button>
                                </div>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</section>

<script>
    $("#verify-form").on('submit', function(e){
        let url = $('#verify-form').attr('action');
        let phone = $('#phone').attr('value');
            e.preventDefault();
            $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        let formData = new FormData(this);
        formData.append('mobile', phone);
        $.ajax({
            url: url,
            method: 'post',
            processData: false,
            contentType: false,
            data:formData,
            success: function(response){
               console.log(response.data , "response data");
               console.log(response.data , "response");
               // $('#invalidOtp').html(response.msg);
                if(response.status == true){
                    Swal.fire({
                        icon: 'success',
                        text: response.msg,
                        showConfirmButton: false,
                        timer: 3000
                    });
               window.location.href = response.url;
           }else if(response.status == false){
                Swal.fire({
                    icon: 'error',
                    text: response.msg,
                    showConfirmButton: false,
                    timer: 3000
                });
               // window.location.href = response.url;
           }
            }
        });
    });


    $('#resendOtp').click(function(e){
    let phone = $('#phone').attr('value');
        $.ajax({
            url: '/resend-otp/'+phone,
            method: 'get',
            success: function(response){
                console.log(response);
                if(response.status == true) {
                    Swal.fire({
                    icon: 'success',
                    text: response.msg,
                    showConfirmButton: false,
                    timer: 3000
                    });
                } else if(response.status == false) {
                    Swal.fire({
                    icon: 'error',
                    text: response.msg,
                    showConfirmButton: false,
                    timer: 3000
                    });
                }
            },
        });
    });

</script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.4.24/dist/sweetalert2.all.min.js"  referrerpolicy="no-referrer"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
@endsection
