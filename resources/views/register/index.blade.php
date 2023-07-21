@extends('layouts.header')

@section('content')
<section class="register-page">
  <div class="row register-row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-register-page">
      <div class="image-register-form">
        <img src="img/register-pic.svg" alt="">
      </div>

      <div class="register-content">
        <div class="img-form mb-3">
          <a href="/"><img src="img/logo-light.svg" alt=""></a>
        </div>
        <div class="form">
          <form action="/register" method="post" class="register-form">
            @csrf
            <div class="mb-2 fullname">
              <label for="inputFullname" class="form-label">Full Name</label>
              <input type="text" class="form-control @error('name_customer') is-invalid @enderror" id="inputFullname" placeholder="Enter Full Name" name="name_customer" value="{{ old('name_customer') }}" required>
            </div>          
            <div class="mb-2 email">
              <label for="inputEmail" class="form-label">Email</label>
              <input type="email" class="form-control @error('email') is-invalid @enderror" id="inputEmail" placeholder="Enter Email" name="email" value="{{ old('email') }}" required>
              @error('email')
                <div class="invalid-feedback">
                  {{ $message }}
                </div>
              @enderror
            </div>
            <div class="mb-2 notelp">
              <label for="inputNotelp" class="form-label">Phone Number</label>
              <input type="tel" class="form-control @error('phone') is-invalid @enderror" id="inputNotelp" placeholder="Enter Phone Number" name="phone" value="{{ old('phone') }}" required>
              @error('phone')
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
            <div class="mb-2 password">
              <label for="inputPasswordconfirmation" class="form-label">Confirm Password</label>
              <input type="password" class="form-control @error('password_confirmation') is-invalid @enderror" id="inputPasswordconfirmation" placeholder="Reenter password to confirm" name="password_confirmation" required>
              @error('password_confirmation')
                <div class="invalid-feedback">
                  {{ $message }}
                </div>
              @enderror
            </div>
            <div class="register-button mt-4">
                <button type="submit" id="tombolRegister" class="btn btn-primary btn-register">Register</button>
            </div>
          </form>

          <p class="text-center p-or">-OR-</p>

          <div>
            <a class="btn btn-outline-dark btn-login" href="" role="button" style="text-transform:none; background-color: white; width: 100%">
              <img width="20px" style="width: 20px !important; margin-bottom:3px; margin-right:5px;" alt="Google sign-in" src="https://upload.wikimedia.org/wikipedia/commons/thumb/5/53/Google_%22G%22_Logo.svg/512px-Google_%22G%22_Logo.svg.png" />
              Register with Google
            </a>
          </div>
        </div>

      <div class="text-signup">
        <p>Already have an account? Please, 
          <span class="signup-text">
            <a href="/login">Log In here</a>.
          </span>
        </p>
      </div>
      
      </div>
    </div>
  </div>
</section>
@endsection
