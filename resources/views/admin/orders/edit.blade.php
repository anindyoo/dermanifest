@extends('layouts.admin.header')

@section('content')
<div class="content">
  <h2>@if ($order_data->status == 'paid') Confirm Order Payment @else Edit Order @endif</h2>
  <hr>
  <h5 class="fw-bold">Order Status</h5>
  <div class="mt-3 mb-4">@include('partials.status', ['status' => $order_data->status])</div>
  <h5 class="fw-bold mb-2">Payment Summary</h5>
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
          <td>{{ $order_data->customer_id }}</td>
        </tr>
        <tr>
          <th>Recipient Name</th>
          <td>{{ $order_data->recipient }}</td>
        </tr>
        <tr>
          <th>Payment Type</th>
          <td>{{ $order_payment->payment_type }}</td>
        </tr>
        <tr>
          <th>Transaction Time</th>
          <td>{{ $order_payment->transaction_time }} WIB</td>
        </tr>
        <tr>
          <th>Grand Total</th>
          <td><strong>Rp{{ number_format($order_data->grand_total, 0, ',', '.') }},-</strong></td>
        </tr>
      </tbody>
    </table>
  </div>
  <h5 class="fw-bold mb-2">@if ($order_data->status == 'paid') Confirm Order Payment @else Edit Order Detail @endif</h5>
  <form action="/admin/orders/{{ $order_data->id }}" method="post">
    @csrf
    @method('put')
    <input type="hidden" name="order_id" value="{{ $order_data->id }}" required>
    <div class="form-group mb-3">
      <label for="select-status" class="form-label">Update Status</label>
      <select name="status" id="select-status" class="form-select">
        @if ($order_data->status == 'paid')
          <option value disabled hidden selected>Select status</option>
        @else
          <option value="{{ $order_data->status }}" selected>{{ ucfirst($order_data->status) }}</option>
        @endif
        <option value="delivering">Delivering</option>
        <option value="Completed">Completed</option>
      </select>
    </div>
    <div class="form-group mb-3">
      <label for="input-delivery_code" class="form-label">Delivery Code</label>
      <input type="text" name="delivery_code" id="input-delivery_code" class="form-control" value="{{ $order_data->delivery_code }}" required>
    </div>
    <div class="text-end">
      <button type="submit" class="btn btn-primary-native"><i class="fa-solid fa-check"></i> @if ($order_data->status == 'paid') Confirm Order Payment @else Update Order @endif</button>
    </div>
  </form>
</div>
@endsection