@extends('layouts.main')

@section('container')
<section class="order-detail container">
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
  <div class="row payment-row mt-4 mb-5">
    <h3>Payment</h3>
    <div class="col-md-12">
      <div class="payment-info gradient-bg mb-3">
        <h5>Please make a payment of <strong>Rp{{ number_format($order_data->grand_total, 0, ', ', '.') }},-</strong></h5>
      </div>
      <div class="payment-buttons d-flex justify-content-end">
        <a href="/profile" class="btn btn-secondary-native me-2">
          Back to Profile
        </a>
        <a href="" class="btn btn-primary-native">
          Pay Now
        </a>
      </div>
    </div>
  </div>
  <div class="row order-detail-row mt-4 mb-5">
    <h3>Order Detail</h3>
    <div class="col-md-4 address-order-detail">
      <div class="order-address-card order-detail-order">
        <h4>Order</h4>
        <h5>Order ID</h5>
        <p>{{ $order_data->id }}</p>
        <h5>Date</h5>
        <p>{{ $order_data->created_at }} WIB</p>
        <h5>Status</h5>
        <p>@include('partials.status_text', ['status' => $order_data->status])</p>
      </div>
      <div class="order-address-card order-detail-recipient">
        <h4>Recipient</h4>    
        <h5>Name</h5>    
        <p>{{ $order_data->recipient }}</p>
        <h5>Email</h5>    
        <p>{{ $order_data->email }}</p>
        <h5>Phone</h5>    
        <p>{{ $order_data->phone }}</p>
      </div>
      <div class="order-address-card order-detail-delivery">
        <h4>Delivery</h4>
        <h5>Address</h5>    
        <p>{{ $order_address_data->name_address }}—{{ $order_address_data->address }}</p>
        <h5>Province</h5>    
        <p>{{ $order_address_data->province }}</p>
        <h5>City</h5>    
        <p>{{ $order_address_data->city }}</p>
        <h5>Postal Code</h5>    
        <p>{{ $order_address_data->postal_code }}</p>
        <h5>Note</h5>    
        <p>@if ($order_data->note != '') {{ $order_data->note }} @else - @endif </p>
      </div>
    </div>
    <div class="col-md-8 product-order-detail cart">
      <div class="table-responsive">
        <table class="table table-responsive table-cartorder table-responsive p-3">
          <thead>
            <tr>
              <th class="text-center"><h5>Product</h5></th>
              <th><h5>Quantity</h5></th>
              <th><h5>Amount</h5></th>
            </tr>
          </thead>
          <tbody>
            @foreach ($order_products_data as $key => $product)            
            <tr class="cart-items">
              <td class="td-product">   
                <div class="d-flex">
                  <a href="/products/{{ $product->product_slug }}"><img src="{{ asset('storage/products/' . $product->main_picture) }}" alt="" style="object-fit: contain;"></a>
                  <div class="d-flex flex-column ms-4">
                    <div class="data-text">
                      <a href="/products/{{ $product->slug }}" class="to-product"><h5 class="mb-1">{{ $product->product_name }}</h5></a>
                      <p>{{ $product->category_name }}</p>
                      @if ($product->discount_price)
                        <h5 class="fw-bold">Rp{{ number_format($product->discount_price, 0, ',', '.') }},-</h5>
                        <del><p>Rp{{ number_format($product->price, 0, ', ', '.') }},-</p></del>                    
                      @else
                        <h5 class="fw-bold">Rp{{ number_format($product->price, 0, ', ', '.') }},-</h5>                    
                      @endif
                    </div>
                  </div>
                </div>                                 
              </td>
                <td class="td-quantity">
                  <h5>{{ $product->quantity }} pcs</h5>
                </td>
                <td>
                  @if ($product->discount_price)
                    <h5 class="fw-bold">Rp{{ number_format($product->discount_price * $product->quantity, 0, ',', '.') }},-</h5>
                  @else
                    <h5 class="fw-bold">Rp{{ number_format($product->price * $product->quantity, 0, ', ', '.') }},-</h5>                    
                  @endif
                </td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
      <div class="order-summary mt-3">
        <h3>Summary</h3>
        <hr>
        <div class="d-flex justify-content-between mb-1">
          <h5 class="poppins-font fw-normal">Quantity Total</h5>
          <h5>{{ $order_data->quantity_total }} pcs</h5>
        </div>
        <div class="d-flex justify-content-between mb-1">
          <h5 class="poppins-font fw-normal">Gross Weight Total</h5>
          <h5>{{ $order_data->gross_weight_total }} gr</h5>
        </div>
        <div class="d-flex justify-content-between mb-1">
          <h5 class="poppins-font fw-normal">Subtotal</h5>
          <h5>Rp{{ number_format($order_data->subtotal, 0, ', ', '.') }},-</h5>
        </div>
        <div class="d-flex justify-content-between mb-1">
          <h5 class="poppins-font fw-normal">Delivery Cost</h5>
          <h5 id="delivery_cost-summary">Rp{{ number_format($order_data->delivery_cost, 0, ', ', '.') }},-</h5>
        </div>
        <hr>
        <div class="d-flex justify-content-between">
          <h5 class="fw-bold">Grand Total</h5>
          <h3 id="grand_total-summary" class="fw-bold">Rp{{ number_format($order_data->grand_total, 0, ', ', '.') }},-</h3>
        </div>
      </div>
    </div>
  </div>
  <div class="row picture-row mt-4 mb-5">
    <div class="col-md-12">
      <img src="{{ asset("img/order_detail_thank_you.svg") }}" alt="Thank you for ordering our products!" class="w-100">
    </div>
  </div>
</section>
@endsection