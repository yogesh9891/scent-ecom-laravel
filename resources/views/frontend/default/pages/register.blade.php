@extends('frontend.default.layouts.app')
@section('content')

<div class="registerpage_page">
      <div class="container">
        <div class="row justify-content-center">
          <div class="col-lg-4">  
              <div class="registerpage">
                <h2>CREATE ACCOUNT</h2>
                <form>
                  <div class="form-group">
                    <label>FIRST NAME</label>
                    <input type="text" name="name" class="form-control">
                  </div>
                  <div class="form-group">
                    <label>LAST NAME</label>
                    <input type="text" name="name" class="form-control">
                  </div>
                   <div class="form-group">
                    <label>EMAIL</label>
                    <input type="email" name="name" class="form-control">
                  </div>
                  <div class="form-group">
                    <label>PASSWORD</label>
                    <input type="password" name="name" class="form-control">
                  </div>
                  <button class="btn btn-link btn-full">CREATE</button>
                </form>
              </div> 
          </div>
        </div>
      </div>
  </div>

@endsection