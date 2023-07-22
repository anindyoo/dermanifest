@extends('layouts.header')

@section('content')
<section class="login-page">
  <div class="row login-row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-login-page">
      <div class="image-login-form">
        <img src="img/login-pic.svg" alt="">
      </div>

      <div class="login-content">
        <div class="img-form mb-3">
          <a href="/"><img src="img/logo-light.svg" alt=""></a>
        </div>
        <div class="form">
          <form action="/login" method="post" class="register-form">
            @csrf
            @if(session()->has('loginError'))
              <div class="alert alert-danger" role="alert">
                {{ session('loginError') }}
              </div>
            @endif
            <div class="mb-2 email">
              <label for="inputEmail" class="form-label">Email</label>
              <input type="email" class="form-control @error('email') is-invalid @enderror" id="inputEmail" placeholder="Enter Email" name="email" value="{{ old('email') }}" required>
              @error('email')
                <div class="invalid-feedback">
                  {{ $message }}
                </div>
              @enderror
            </div>
            <div class="mb-2 password">
              <label for="inputPassword" class="form-label">Password</label>
              <input type="password" class="form-control @error('password') is-invalid @enderror" id="inputPassword" placeholder="Enter password" name="password" value="{{ old('password') }}" required>
              @error('password')
                <div class="invalid-feedback">
                  {{ $message }}
                </div>
              @enderror
            </div>   
            <div class="login-button mt-4">
              <button type="submit" name="login" class="btn btn-primary btn-login">Log In</button>
            </div>
          </form> 

          <p class="text-center p-or">-OR-</p>

          @include('partials/google-button', ['type' => 'Log In'])
        </div>

        <div class="text-signup">
          <p>Don't have an account? Please, 
            <span class="signup-text">
              <a href="/register">Register here</a>.
            </span>
          </p>
        </div>
      </div>
    </div>
  </div>
</section>
@endsection