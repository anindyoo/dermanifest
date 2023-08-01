@extends('layouts.header')

@section('content')
  @include('partials/navbar')
  
  @yield('container')

  @include('partials/bottom_navbar')  
@endsection