@extends('layouts.main')

@section('csrf_token')
<script type="text/javascript"
  src="https://app.midtrans.com/snap/snap.js"
  data-client-key="{{ env('MIDTRANS_CLIENT_KEY') }}"></script>
@endsection

@section('container')
<section class="odrer-payment container">
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
  <div class="row payment-detail-row mt-4 mb-5">
    <h3>Payment</h3>
    <div class="accdetail mb-3">
      <h5>Payment Detail</h5>
      <div class="form-group mb-2 checkout-data">
        <label class="form-label">Order Id</label>
        <input id="name" type="text" class="form-control" name="order_id" value="{{ $order_data->id }}" required>
      </div>
      <div class="form-group mb-2 checkout-data">
        <label class="form-label">Recipient</label>
        <input id="recipient" type="text" class="form-control" name="recipient" value="{{ $order_data->recipient }}" required>
      </div>
      <div class="form-group mb-2 checkout-data">
        <label class="form-label">Email</label>
        <input id="email" type="email" class="form-control" name="email" value="{{ $order_data->email }}" required>
      </div>
      <div class="form-group mb-2 checkout-data">
        <label class="form-label">Phone</label>
        <input id="phone" type="tel" class="form-control" name="phone" value="{{ $order_data->phone }}" required>
      </div>
      <div class="form-group mb-2 checkout-data">
        <label class="form-label">Grand Total</label>
        <input type="text" class="form-control" value="Rp{{ number_format($order_data->grand_total, 0, ', ', '.') }},-" required>
        <input id="grand_total" type="hidden" class="form-control" name="grand_total" value="{{ $order_data->grand_total }}" required>
      </div>
    </div>
    <div class="payment-buttons d-flex justify-content-end">
      <a href="/profile" class="btn btn-secondary-native me-2">
        Back to Profile
      </a>
      @if ($order_data->status == 'unpaid')
      <button id="pay-button" href="" class="btn btn-primary-native">
        Pay Now
      </button>        
      @else
      <a href="/order/invoice/{{ $order_data->id }}" class="btn btn-primary-native me-2">
        See Invoice
      </a>
      @endif
    </div>
  </div>
</section>
@endsection

@section('js_code')
<script type="text/javascript">
  var payButton = document.getElementById('pay-button');
  payButton.addEventListener('click', function () {
    window.snap.pay("{{ $snap_token }}", {
      onError: function(result){
        alert("Payment failed!"); console.log(result);
      },
    })
  });
</script>
@endsection