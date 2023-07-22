@extends('layouts.header')

@section('content')
<section class="verification-page">
  <i class="fa-solid fa-envelope-open-text email-icon" style="color: #333d29;"></i>
  <h1 class="mb-4">Verify your email!</h1>

  @if(Auth::user()->email_verified_at == null)
    <p class="text-center verify-desc mb-4">A verification link has been sent to your email: 
      <br> <strong>{{ Auth::user()->email }}</strong>. <br> <br>
      Please verify your email first in order to start transactions on Dermanifest.
      If you don't see the email, you may need to check your spam or promotions folder on your email provider.
    </p>
    <h5 class="mb-2">Still can't find the email?</h5>
    <form action="{{ route('verification.send') }}" method="post">
      @csrf
      <button type="submit" class="btn btn-primary-native">Resend Verification Link</button>
    </form>
  @else
    <p class="text-center verify-desc mb-4">
      Your email has already been verified. You can now start any transactions on Dermanifest. 
      <br> <strong> Thank you! </strong>
    </p>
  @endif
  <a href="/" class="mt-3" style="color: #333d29; text-decoration: underline;">Back to home</a>
  @if(session()->has('message'))
    <div class="home-alert">
      <div class="alert alert-success" role="alert">
        {{ session('message') }}
      </div>
    </div>
  @endif
</section>
@endsection