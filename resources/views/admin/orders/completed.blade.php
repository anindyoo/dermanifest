@extends('layouts.admin.header')

@section('content')
<div class="content">
  <h2>Completed Orders</h2>
  <hr>
  <div>
    @if(session()->has('success'))
      @include('partials/alert', [
        'status' => 'success',
        'message' => session('success'),
      ])
    @endif
  </div>
  <div class="table-responsive">
    <table class="table table-bordered table-striped table-hover">
      <thead class="table-light manrope-font">
        <tr>
          <th scope="col">No.</th>
          <th scope="col">Order Id</th>
          <th scope="col">Recipient</th>
          <th scope="col">Order Date</th>
          <th scope="col">Quantity</th>
          <th scope="col">Subtotal (excl. delivery)</th>
          <th scope="col">Actions</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($completed_orders as $order)
          <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $order->id }}</td>
            <td>{{ $order->recipient }}</td>
            <td>{{ $order->created_at }} WIB</td>
            <td>{{ $order->quantity_total }}</td>
            <td>Rp{{ number_format($order->subtotal, 0, ', ', '.') }},-</td>
            <td>
              @include('partials.status_button', [
                'status' => 'completed',
                'order_id' => $order->id,
                'role' => 'admin',
                ]) 
            </td>
          </tr>
        @endforeach
      </tbody>
      <tfoot>
        <tr>
          <td colspan="4"><strong>Total</strong></td>
          <td><strong>{{ $quantity }}</strong></td>
          <td><strong>Rp{{ number_format($subtotal, 0, ', ', '.') }},-</strong></td>
          <td></td>
        </tr>
      </tfoot>
    </table>
  </div>
</div>
@endsection