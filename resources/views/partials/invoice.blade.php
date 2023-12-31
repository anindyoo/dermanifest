<div id="invoice-print" class="row invoice-row mt-5 mb-5 d-flex justify-content-center">
  <div class="invoice-container">
    <div class="d-flex invoice-header justify-content-between align-items-start">
      <img src="{{ asset('img/logo-dark.webp') }}" alt="Dermanifest Logo">
      <div class="text-end">
        <h1>INVOICE</h1>
        <h5 class="mt-3 fw-bold">DERMANIFEST</h5>
        <h6>dermanifest@gmail.com</h6>
      </div>
    </div>
    <div class="d-flex invoice-subheader align-items-start mt-4">
      <div class="invoice-to me-4">
        <h5 class="fw-bold">Invoice To</h5>
        <table class="table table-borderless">
          <tr>
            <td class="no-horizontal-p">Name</td>          
            <td>:</td>
            <td> {{ $order_data->recipient }}</td>
          </tr>
          <tr>
            <td class="no-horizontal-p">Email</td>          
            <td>:</td>
            <td> {{ $order_data->email }}</td>
          </tr>
          <tr>
            <td class="no-horizontal-p">Phone</td>          
            <td>:</td>
            <td> {{ $order_data->phone }}</td>
          </tr>
        </table>
      </div>
      <div class="order-details">
        <h5 class="fw-bold">Order Details</h5>
        <table class="table table-borderless">
          <tr>
            <td class="no-horizontal-p">Order Id</td>          
            <td>:</td>
            <td> {{ $order_data->id }}</td>
          </tr>
          <tr>
            <td class="no-horizontal-p">Order Date</td>          
            <td>:</td>
            <td> {{ $order_data->created_at }} WIB</td>
          </tr>
          <tr>
            <td class="no-horizontal-p">Status</td>          
            <td>:</td>
            <td> @include('partials.status_text', ['status' => $order_data->status])</td>
          </tr>
        </table>
      </div>
    </div>
    <div class="d-flex invoice-products">
      <table class="table">
        <thead class="table-light">
          <tr>
            <th scope="col">No.</th>
            <th scope="col">Item</th>
            <th scope="col">Qty</th>
            <th scope="col">Price</th>
            <th scope="col">Amount</th>
          </tr>
        </thead>
        <tbody class="table-group-divider">
          @foreach ($order_products as $product)
            <tr>
              <th scope="row">{{ $loop->iteration }}</th>
              <td>{{ $product->product_name }}</td>
              <td>{{ $product->quantity }}</td>
              <td>
                @if ($product->discount_price)
                  <div class="">Rp{{ number_format($product->discount_price, 0, ',', '.') }},-</div>
                  <del>Rp{{ number_format($product->price, 0, ', ', '.') }},-</del>                    
                @else
                  <div class="">Rp{{ number_format($product->price, 0, ', ', '.') }},-</div>                    
                @endif
              </td>
              <td>Rp{{ number_format($product->price_total, 0, ', ', '.') }},-</td>
            </tr>                
          @endforeach
        </tbody>
        <tfoot class="table-group-divider">
          <tr>
            <td colspan="2">Subtotal</td>
            <td>{{ $order_data->quantity_total }}</td>
            <td></td>
            <td>Rp{{ number_format($order_data->subtotal, 0, ', ', '.') }},-</td>
          </tr>
        </tfoot>
      </table>        
    </div>
    <div class="d-flex invoice-totals justify-content-end">
      <div class="totals-card">
        <div class="d-flex justify-content-between mb-1">
          <h6 class="poppins-font fw-normal">Subtotal</h6>
          <h6>Rp{{ number_format($order_data->subtotal, 0, ', ', '.') }},-</h6>
        </div>
        <div class="d-flex justify-content-between mb-1">
          <h6 class="poppins-font fw-normal">Delivery Cost</h6>
          <h6 id="delivery_cost-summary">Rp{{ number_format($order_data->delivery_cost, 0, ', ', '.') }},-</h6>
        </div>
        <hr>
        <div class="d-flex justify-content-between">
          <h6 class="fw-bold">Grand Total</h6>
          <h6 id="grand_total-summary" class="fw-bold">Rp{{ number_format($order_data->grand_total, 0, ', ', '.') }},-</h6>
        </div>
      </div>
    </div>
    <div class="d-flex invoice-delivery mt-3 flex-column">
      <h5 class="fw-bold">Payment Details</h5>
      <table class="table table-borderless mb-1">
        <tbody>
          <tr>
            <td class="field-name no-horizontal-p">Payment Type</td>
            <td class="colon">:</td>
            <td class="field-value">{{ $order_payment->payment_type }}</td>
          </tr>
          <tr>
            <td class="field-name no-horizontal-p">Transaction Time</td>
            <td class="colon">:</td>
            <td class="field-value">{{ $order_payment->transaction_time }} WIB</td>
          </tr>
          <tr>
            <td class="field-name no-horizontal-p">Gross Amount</td>
            <td class="colon">:</td>
            <td class="field-value">Rp{{ number_format($order_payment->gross_amount, 0, ', ', '.') }},-</td>
          </tr>
        </tbody>
      </table>
      <small><em>Please check your email <strong>({{ $order_data->email }})</strong> to see your Midtrans transaction reciept.</em></small>
    </div>
    <div class="d-flex invoice-delivery mt-3 flex-column">
      <h5 class="fw-bold">Delivery Details</h5>
      <table class="table table-borderless">
        <tbody>
          <tr>
            <td class="field-name no-horizontal-p">Address</td>
            <td class="colon">:</td>
            <td class="field-value">{{ $order_address->address }}</td>
          </tr>
          <tr>
            <td class="field-name no-horizontal-p">Province</td>
            <td class="colon">:</td>
            <td class="field-value">{{ $order_address->province }}</td>
          </tr>
          <tr>
            <td class="field-name no-horizontal-p">City</td>
            <td class="colon">:</td>
            <td class="field-value">{{ $order_address->city }}</td>
          </tr>
          <tr>
            <td class="field-name no-horizontal-p">Postal Code</td>
            <td class="colon">:</td>
            <td class="field-value">{{ $order_address->postal_code }}</td>
          </tr>
          <tr>
            <td class="field-name no-horizontal-p">Note</td>
            <td class="colon">:</td>
            <td class="field-value"> @if ($order_data->note) {{ $order_data->note }} @else - @endif</td>
          </tr>
          <tr>
            <td class="field-name no-horizontal-p">Gross Weight</td>
            <td class="colon">:</td>
            <td class="field-value">{{ $order_data->gross_weight_total }} gr</td>
          </tr>
          <tr>
            <td class="field-name no-horizontal-p">Delivery Courier</td>
            <td class="colon">:</td>
            <td class="field-value">{{ $order_data->delivery_courier }}</td>
          </tr>
          <tr>
            <td class="field-name no-horizontal-p">Delivery Service</td>
            <td class="colon">:</td>
            <td class="field-value">{{ $order_data->delivery_service }}</td>
          </tr>
          <tr>
            <td class="field-name no-horizontal-p">Delivery Cost</td>
            <td class="colon">:</td>
            <td class="field-value">Rp{{ number_format($order_data->delivery_cost, 0, ', ', '.') }},-</td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
  <style>
    /* Order Invoice */
    .invoice-row {
      padding: 0 5px;
    }
    .invoice-container {
      border: 1.2px solid #6C6C6C;
      max-width: 714px;
      padding: 58px 28px;
      background-color: #ffffff;
      overflow: auto;
    }
    .invoice-header img {
      height: 12vh;
    }
    .invoice-subheader p {
      margin-bottom: 3px;
    }
    .invoice-subheader td, 
    .invoice-delivery td {
      padding-top: 0 !important;
      padding-bottom: 0 !important;
    }
    .no-horizontal-p {
      padding-left: 0 !important;
      padding-right: 0 !important;
    }
    .invoice-products table thead {
      background: #F8F9FA;
    }
    .invoice-products table tfoot {
      background: #E5E5E5;
    }
    .invoice-products del {
      font-size: 0.8em;
    }
    .invoice-totals hr {
      margin: 7px 0;
    }
    .totals-card {
      width: 328px;
      padding: 14px 18px;
      border-radius: 3.6px;
      border: 1.2px solid #BDBDBD;
      background: #E5E9DB;
    }
    .invoice-delivery .field-name {
      width: 21%;
    }
    .invoice-delivery .colon {
      width: 1%;
    }
    .invoice-delivery .field-value {
      width: 68%;
    }
    .invoice-container table > tfoot > tr > td{
    border:1px solid #E5E5E5;
    background: #E5E5E5;
    }
    </style>
</div>
<script>
  function printDiv() {
  var printContents = document.getElementById('invoice-print').innerHTML;
  var originalContents = document.body.innerHTML;
  document.body.innerHTML = printContents;
  window.print();
  document.body.innerHTML = originalContents;
}
</script>