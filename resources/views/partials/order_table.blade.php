<div class="table-responsive">
  @if (isset($role) AND $role == 'admin')
  <table class="table table-bordered table-striped table-hover">
  @else    
  <table class="table">
  @endif
    <thead class="table-light manrope-font">
      <tr>
        <th scope="col">No.</th>
        <th scope="col">Order Id</th>
        @if (isset($role) AND $role == 'admin') <th scope="col">Recipient</th> @endif
        <th scope="col">Date</th>
        <th scope="col">Grand Total</th>
        <th scope="col">Status</th>
        <th scope="col">Action</th>
      </tr>
    </thead>
    <tbody>
      @forelse ($orders as $order)
      @if ($status == 'all' OR $status == $order->status)
        <tr>
          <th scope="row" class="manrope-font">{{ $loop->iteration }}.</th>
          <td>{{ $order->id }}</td>
          @if (isset($role) AND $role == 'admin') <td>{{ $order->recipient }}</td> @endif
          <td>{{ $order->created_at }} WIB</td>
          <td>Rp{{ number_format($order->grand_total, 0, ', ', '.') }},-</td>
          <td>
            @include('partials.status', ['status' => $order->status])
            @if (!isset($role) AND $order->status == 'delivering') 
            <div class="mt-2">Delivery Code: {{ $order->delivery_code }}</div> @endif
          </td>
          <td>
            @if (isset($role) AND $role == 'admin')
              @include('partials.status_button', [
                'status' => $order->status,
                'order_id' => $order->id,
                'role' => 'admin',
                ])                          
            @else
              @include('partials.status_button', [
                'status' => $order->status,
                'order_id' => $order->id,
                ])                
            @endif
          </td>
        </tr>                            
      @endif
      @empty
      <tr>
        <td colspan="100%" class="text-center">
          <h5>You have no orders, yet.</h5>
        </td>
      </tr>
      @endforelse
    </tbody>
  </table>
</div>