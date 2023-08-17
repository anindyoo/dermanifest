@extends('layouts.admin.header')

@section('content')
<div class="content">
  <h2>Customer Detail</h2>
  <hr>
  <div class="table-responsive">
    <table class="table table-bordered table-striped table-hover table-header-on-left">
      <tbody>
        <tr>
          <th>Customer Id</th>
          <td>{{ $customer_data->id }}</td>
        </tr>        
        <tr>
          <th>Name</th>
          <td>{{ $customer_data->name_customer }}</td>
        </tr>        
        <tr>
          <th>Email</th>
          <td>{{ $customer_data->email }}</td>
        </tr>        
        <tr>
          <th>Phone</th>
          <td>{{ $customer_data->phone }}</td>
        </tr>        
        <tr>
          <th>Transactions Total</th>
          <td>{{ $customer_data->transactions_total }}</td>
        </tr>        
      </tbody>
    </table>
  <h5 class="fw-bold mb-2">Customer Addresses</h5>
  <div class="table-responsive">
    <table class="table table-bordered table-striped table-hover">
      <thead class="table-light manrope-font">
        <tr>
          <th scope="col">No.</th>
          <th scope="col">Address Title</th>
          <th scope="col">Address</th>
          <th scope="col">Province</th>
          <th scope="col">City/District</th>
          <th scope="col">Postal Code</th>          
        </tr>
      </thead>
      <tbody>
        @foreach ($customer_addresses as $address)
          <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $address->name_address }}</td>
            <td>{{ $address->address }}</td>
            <td>{{ $address->province }}</td>
            <td>{{ $address->city }}</td>
            <td>{{ $address->postal_code }}</td>
          </tr>
        @endforeach
      </tbody>
    </table>
  </div>
  <h5 class="fw-bold mb-2">Customer Orders</h5>
  <label for="select-status" class="form-label">Filter Order</label>
  <select id="filter-order" class="form-select mb-3">
    <option value="all-table">All Order</option>
    <option value="unpaid-table">Unpaid</option>
    <option value="paid-table">Paid</option>
    <option value="delivering-table">Delivering</option>
    <option value="completed-table">Completed</option>
  </select>
  <div id="all-table" class="table-wrapper">
    @include('partials.admin.customer_order_table', [
      'customer_orders' => $customer_orders, 
      'subtotal' => $subtotal, 
      'quantity' => $quantity
    ])
  </div>
  <div id="unpaid-table" class="table-wrapper d-none">
    @include('partials.admin.customer_order_table', [
      'customer_orders' => $unpaid_orders['data'], 
      'subtotal' => $unpaid_orders['subtotal'], 
      'quantity' => $unpaid_orders['quantity']
    ])
  </div>
  <div id="paid-table" class="table-wrapper d-none">
    @include('partials.admin.customer_order_table', [
      'customer_orders' => $paid_orders['data'], 
      'subtotal' => $paid_orders['subtotal'], 
      'quantity' => $paid_orders['quantity']
    ])
  </div>
  <div id="delivering-table" class="table-wrapper d-none">
    @include('partials.admin.customer_order_table', [
      'customer_orders' => $delivering_orders['data'], 
      'subtotal' => $delivering_orders['subtotal'], 
      'quantity' => $delivering_orders['quantity']
    ])
  </div>
  <div id="completed-table" class="table-wrapper d-none">
    @include('partials.admin.customer_order_table', [
      'customer_orders' => $completed_orders['data'], 
      'subtotal' => $completed_orders['subtotal'], 
      'quantity' => $completed_orders['quantity']
    ])
  </div>
</div>
@endsection
@section('js_code')
<script>
$(document).ready(function() {
  $('#filter-order').change(function() {
    $('.table-wrapper').addClass('d-none');
    $('#' + this.value).removeClass('d-none');
  });
});
</script>
@endsection