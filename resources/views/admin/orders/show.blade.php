@extends('layouts.admin.header')

@section('content')
<div class="content">
  <h2>Order Detail</h2>
  <hr>
  <h5 class="fw-bold">Order Status</h5>
  <div class="mt-3 mb-4">@include('partials.status', ['status' => $order_data->status])</div>
  <h5 class="fw-bold mb-2">Recipient & Order Detail</h5>
  <div class="table-responsive">
    <table class="table table-bordered table-striped table-hover table-header-on-left">
      <tbody>
        <tr>
          <th>Order Id</th>
          <td>{{ $order_data->id }}</td>
        </tr>
        <tr>
          <th>Date Created</th>
          <td>{{ $order_data->created_at }} WIB</td>
        </tr>
        <tr>
          <th>Customer Id</th>
          <td><a href="/admin/customers/{{ $order_data->customer_id }}" class="text-primary-native">{{ $order_data->customer_id }} <i class="fas fa-external-link-alt fa-xs"></i></a></td>
        </tr>
        <tr>
          <th>Recipient Name</th>
          <td>{{ $order_data->recipient }}</td>
        </tr>
        <tr>
          <th>Email</th>
          <td>{{ $order_data->email }}</td>
        </tr>
        <tr>
          <th>Phone</th>
          <td>{{ $order_data->phone }}</td>
        </tr>
      </tbody>
    </table>
  </div>
  <h5 class="fw-bold mb-2">Delivery Detail</h5>
  <div class="table-responsive">
    <table class="table table-bordered table-striped table-hover table-header-on-left">
      <tbody>
        <tr>
          <th>Address Title</th>
          <td>{{ $order_address->name_address }}</td>
        </tr>
        <tr>
          <th>Address</th>
          <td>{{ $order_address->address }}</td>
        </tr>
        <tr>
          <th>Province</th>
          <td>{{ $order_address->province }}</td>
        </tr>
        <tr>
          <th>City</th>
          <td>{{ $order_address->city }}</td>
        </tr>
        <tr>
          <th>Postal Code</th>
          <td>{{ $order_address->postal_code }}</td>
        </tr>
        <tr>
          <th>Note</th>
          <td class="field-value"> @if ($order_address->note) {{ $order_address->note }} @else - @endif</td>
        </tr>
      </tbody>
    </table>
  </div>
  <h5 class="fw-bold mb-2">Ordered Products</h5>
  <div class="table-responsive">
    <table class="table table-bordered table-striped table-hover">
      <thead>
        <tr>
          <th>No.</th>
          <th>Picture</th>
          <th>Product Name</th>
          <th>Quantity</th>
          <th>Price</th>
          <th>Amount</th>
        </tr>
      </thead>
      <tbody class="table-group-divider">
        @foreach ($order_products as $product)
          <tr>
            <td>{{ $loop->iteration }}</td>
            <td>
              <a href="/products/{{ $product->slug }}">
                <img src="{{ asset('storage/products/' . $product->main_picture) }}" alt="{{ $product->product_name }}" style="object-fit: contain;" width="100" class="rounded-3">
              </a>
            </td>
            <td><a href="/products/{{ $product->product_slug }}" class="btn text-start p-0">{{ $product->product_name }}</a></td>
            <td>{{ $product->quantity }}</td>
            <td>
              @if ($product->discount_price)
                <div>Rp{{ number_format($product->discount_price, 0, ',', '.') }},-</div>
                <small><del>Rp{{ number_format($product->price, 0, ', ', '.') }},-</del></small>
              @else
                <div>Rp{{ number_format($product->price, 0, ', ', '.') }},-</div>                    
              @endif
            </td>
            <td>Rp{{ number_format($product->price_total, 0, ',', '.') }},-</td>
          </tr>
        @endforeach
      </tbody>
      <tfoot class="table-group-divider">
        <tr>
          <td colspan="3">Subtotal</td>
          <td>{{ $order_data->quantity_total }}</td>
          <td></td>
          <td>Rp{{ number_format($order_data->subtotal, 0, ',', '.') }},-</td>
        </tr>
      </tfoot>
    </table>
  </div>
  <h5 class="fw-bold mb-2">Order Summary</h5>
  <div class="table-responsive">
    <table class="table table-bordered table-striped table-hover table-header-on-left">
      <tbody>
        <tr>
          <th>Quantity Total</th>
          <td>{{ $order_data->quantity_total }} pcs</td>
        </tr>
        <tr>
          <th>Gross Weight Total</th>
          <td>{{ $order_data->gross_weight_total }} gr</td>
        </tr>
        <tr>
          <th>Subtotal</th>
          <td>Rp{{ number_format($order_data->subtotal, 0, ',', '.') }},-</td>
        </tr>
        <tr>
          <th>Delivery Cost</th>
          <td>Rp{{ number_format($order_data->delivery_cost, 0, ',', '.') }},-</td>
        </tr>
        <tr>
          <th>Grand Total</th>
          <td><strong>Rp{{ number_format($order_data->grand_total, 0, ',', '.') }},-</strong></td>
        </tr>
      </tbody>
    </table>
  </div>
  @if ($order_data->status != 'unpaid')
  <h5 class="fw-bold mb-2">Order Invoice</h5>
  <button type="submit" class="btn btn-primary-native" onclick="printDiv()">Print Invoice</button>
  @include('partials.invoice')  
  @endif
</div>
@endsection