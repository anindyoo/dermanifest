@extends('layouts.main')

@section('container')

<section class="order-invoice container">
  @if(session()->has('success'))
  <div class="home-alert">
    @include('partials/alert', [
      'status' => 'success',
      'message' => session('success'),
    ])
  </div>
  @elseif(session()->has('danger'))
  <div class="home-alert">
    @include('partials/alert', [
      'status' => 'danger',
      'message' => session('danger'),
    ])
  </div>
  @endif
  <div class="row mt-4">
    <div class="col-md-12">
      <h3>Invoice</h3>
      <h6>Invoice for <strong>Order Id: {{ $order_data->id }}</strong></h6>
    </div>
  </div>
  <div class="row">
    <div class="d-flex justify-content-end">
      <a href="/profile" class="btn btn-secondary-native me-2">
        Back to Profile
      </a>
      <btn id="print" class="btn btn-primary-native" onclick="printDiv()">
        Print Invoice
      </btn>
    </div>
  </div>
  @include('partials.invoice')
</section>
@endsection