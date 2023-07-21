@extends('layouts.header')

@section('content')
  @include('partials/navbar')
  <div>
    @yield('container')
  </div>
  @include('partials/bottom_navbar')  
@endsection