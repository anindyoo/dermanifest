@extends('layouts.admin.header')

@section('content')
<div class="content">
  <h2>Orders Management</h2>
  <hr>
  <div>
    @if(session()->has('success'))
      @include('partials/alert', [
        'status' => 'success',
        'message' => session('success'),
      ])
    @endif
  </div>
  <div class="table-wrapper" style="overflow-x: auto;">
    <table class="table table-bordered table-striped table-hover">
      <thead>
        <tr>
          <th>No.</th>
          <th>Order Id</th>
          <th>Recipient</th>
          <th>Grand Total</th>
          <th>Status</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($orders_data as $order)
          <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $order->id }}</td>
            <td>{{ $order->recipient }}</td>
            <td>Rp{{ number_format($order->grand_total, 0, ', ', '.') }},-</td>
            <td>@include('partials.status', ['status' => $order->status])</td><td>
              @include('partials.status_button', [
                'status' => $order->status,
                'order_id' => $order->id,
                'role' => 'admin'
              ])
            </td>
          </tr>
        @endforeach
      </tbody>
    </table>
  </div>
</div>

@endsection