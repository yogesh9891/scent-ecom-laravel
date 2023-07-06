@extends('frontend.default.layouts.app')

@section('content')

<div class="aboutimgbg-top">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <h3>Contact Us</h3>
                </div>
            </div>
        </div>
    </div>
    <div class="conact_page pt-50 pb-50">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8 text-center">
                    <h1>Our Main Office.</h1>
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
                    tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
                    quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
                    </p>
                </div>
            </div>
            <div class="row justify-content-center mt-5">
                <div class="col-lg-3">
                    <div class="border-coladd">
                        <img src="https://mageblueskytech.com/rubix/media/wysiwyg/xContact_icon1.png.pagespeed.ic.748eJdiLUS.webp" alt="">
                        <h4 class="mt-3">Location</h4>
                        <p>Connaught Place, New Delhi, Delhi 110001</p>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="border-coladd">
                        <img src="https://mageblueskytech.com/rubix/media/wysiwyg/xContact_icon2.png.pagespeed.ic.mxhLkrbC6v.webp" alt="">
                            <h4 class="mt-3">Email Support 24/7</h4>
                            <p>Email: demo@gmail<br>Email: demo@gmail.com</p>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="border-coladd">
                        <img src="https://mageblueskytech.com/rubix/media/wysiwyg/xContact_icon3.png.pagespeed.ic.OkgZ2OK5Lj.webp" alt="">
                        <h4 class="mt-3">Phone Number</h4>
                        <p >Phone: (+100) 000 000 0000<br>Fax: (+100) 000 000 0000 / 0000</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="conact_page pt-50 pb-50">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-12 text-center">
                    <h4>Request A Fragrent</h4>
                      <p>Couldn’t find what you are looking for ?? Please help us with details below and we will try to source it for you !!</p>
                      <form action="http://scentoria.ebslon.com/request-fragrent" class="row" method="POST">
                          @csrf    
                          <div class="form-group col-md-6">
                          <input type="text" class="form-control" name="name" placeholder="Your Name">
                        </div>
                        <div class="form-group col-md-6">
                          <input type="email" class="form-control" required="" name="email" placeholder="Your Email Id">
                        </div>
                        <div class="form-group col-md-6">
                          <input type="text" class="form-control" name="phone" maxlength="10" placeholder="Your Mobile No." required="">
                        </div>
                        <div class="form-group col-md-6">
                          <input type="text" class="form-control" name="brand" placeholder="Brand" required="">
                        </div>
                        <div class="form-group col-md-6">
                          <input type="text" class="form-control" name="item" placeholder="Item Name" required="">
                        </div>
                        <div class="form-group col-md-6">
                          <input type="text" class="form-control" name="size" placeholder="Size" required="">
                        </div>
                        <div class="form-group col-md-12">
                          <textarea class="form-control" name="message" placeholder="Additional Remark"></textarea>
                        </div>
                        <div class="form-group col-md-6">
                        <button class="btn-full btn-link" type="submit" value="submit">Submit</button>
                        </div>
                      </form>
                </div>
            </div>
           
        </div>
    </div>

@endsection
@push('scripts')
<script>

    (function($){
        "use strict";

        $(document).ready(function() {

            $('#contactForm').on('submit', function(event) {
                event.preventDefault();
                // console.log('ok')
                $("#contactBtn").prop('disabled', true);
                $('#contactBtn').text('{{ __('common.submitting') }}');

                var formElement = $(this).serializeArray()
                var formData = new FormData();
                formElement.forEach(element => {
                    formData.append(element.name, element.value);
                });

                if($('.custom_file').length > 0){
                    let photo = $('.custom_file')[0].files[0];
                    if (photo) {
                        formData.append($('.custom_file').attr('name'), photo)
                    }
                }
                
                formData.append('_token', "{{ csrf_token() }}");
                
                $.ajax({
                    url: "{{ route('contact.store') }}",
                    type: "POST",
                    cache: false,
                    contentType: false,
                    processData: false,
                    data: formData,
                    success: function(response) {
                        toastr.success("{{__('defaultTheme.message_sent_successfully')}}","{{__('common.success')}}");
                        $("#contactBtn").prop('disabled', false);
                        $('#contactBtn').text("{{ __('defaultTheme.send_message') }}");
                        resetErrorData();

                    },
                    error: function(response) {
                        toastr.error("{{__('common.error_message')}}", "{{__('common.error')}}");
                        $("#contactBtn").prop('disabled', false);
                        $('#contactBtn').text("{{ __('defaultTheme.send_message') }}");
                        showErrorData(response.responseJSON.errors)

                    }
                });
            });

            function showErrorData(errors){
                $('#contactForm #error_name').text(errors.name);
                $('#contactForm #error_email').text(errors.email);
                $('#contactForm #error_query_type').text(errors.query_type);
                $('#contactForm #error_message').text(errors.message);
            }

            function resetErrorData(){
                $('#contactForm')[0].reset();
                $('#contactForm #error_name').text('');
                $('#contactForm #error_email').text('');
                $('#contactForm #error_query_type').text('');
                $('#contactForm #error_message').text('');
            }
        });
    })(jQuery);


</script>
@endpush
