@extends('layouts.admin.header')

@section('content')
<div class="content">
  <h2>Add Admin</h2>
  <hr>
  @if(session()->has('danger'))
  <div class="home-alert">
    @include('partials/alert', [
      'status' => 'danger',
      'message' => session('danger'),
    ])
  </div>
  @endif
  <form action="/admin/admins_management" method="post">
    @csrf
    <div class="form-group mb-3">
      <label class="form-label">Admin Name</label>
      <input type="text" class="form-control @error('name_admin') is-invalid @enderror" name="name_admin" value="{{ old('name_admin') }}" required>
      @error('name_admin')
        <div class="invalid-feedback">
          {{ $message }}
        </div>
      @enderror
    </div>
    <div class="form-group mb-3">
      <label class="form-label">Email</label>
      <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required>
      @error('email')
        <div class="invalid-feedback">
          {{ $message }}
        </div>
      @enderror
    </div>
    <div class="form-group mb-3">
      <label class="form-label">Password</label>
      <input type="password" class="form-control @error('password') is-invalid @enderror" name="password" required>
      @error('password')
        <div class="invalid-feedback">
          {{ $message }}
        </div>
      @enderror
    </div>
    <div class="form-group mb-3">
      <label class="form-label">Password Confirmation</label>
      <input type="password" class="form-control @error('password_confirmation') is-invalid @enderror" name="password_confirmation" required>
      @error('password_confirmation]')
        <div class="invalid-feedback">
          {{ $message }}
        </div>
      @enderror
    </div>
    <div class="text-end">
      <button type="submit" class="btn btn-primary-native"><span class="fa-solid fa-circle-check"></span> Add New Admin</button>
    </div>
  </form>
</div>
@endsection