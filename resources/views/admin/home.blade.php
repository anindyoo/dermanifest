@extends('layouts.admin.header')

@section('content')
<div class="content">
  <h2>Home</h2>
  <hr>
  <div class="row">
    <div class="col-md my-card">
      <div class="card-icon"><h1><i class="fa-solid fa-users"></i></h1></div>
      <div class="card-desc">
        <div class="card-value text-end"><h5>{{ $customers_total }}</h5></div>
        <div class="card-value-desc text-end"><h3>Customers</h3></div>
      </div>
    </div>
    <div class="col-md my-card">
      <div class="card-icon"><h1><i class="fa-solid fa-cart-shopping"></i></h1></div>
      <div class="card-desc">
        <div class="card-value text-end"><h5>{{ $orders_total }}</h5></div>
        <div class="card-value-desc text-end"><h3>Overrall Orders</h3></div>
      </div>
    </div>
    <div class="col-md my-card">
      <div class="card-icon"><h1><i class="fa-solid fa-clock"></i></h1></div>
      <div class="card-desc">
        <div class="card-value text-end"><h5>{{ $paid_orders_total }}</h5></div>
        <div class="card-value-desc text-end"><h3>Waiting Orders</h3></div>
      </div>
    </div>
    <div class="col-md my-card">
      <div class="card-icon"><h1><i class="fa-solid fa-money-bill-trend-up"></i></h1></div>
      <div class="card-desc">
        <div class="card-value text-end"><h5>Rp{{ number_format($gross_sales, 0, ', ', '.') }},-</h5></div>
        <div class="card-value-desc text-end"><h3>Gross Sales</h3></div>
      </div>
    </div>
  </div>
  <p>
    Welcome to Admin Page, <strong>{{ Auth::user()->name_admin }}</strong>
  </p>
</div>
@endsection