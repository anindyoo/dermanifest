@if (isset($role) && $role == 'admin')
  <div>
    <a href="/admin/orders/{{ $order_id }}" class="btn btn-info text-white me-1"><i class="fa-solid fa-circle-info"></i> Detail</a>
  @if ($status == 'unpaid')
    <a href="" class="btn btn-danger me-1" data-bs-toggle="modal" data-bs-target="#cancelOrder-{{ $order_id }}"><i class="fa-solid fa-xmark"></i> Cancel</a>
    
    @include('partials/modal', [
      'modal_id' => 'cancelOrder-' . $order_id,
      'modal_title' => 'Cancel Order',
      'include_form' => 'true',
      'form_action' => '/admin/orders/' . $order_id ,
      'form_method' => 'post', 
      'additional_form_method' => 'delete', 
      'modal_body' => '
      Are you sure to cancel <strong> Order #' . $order_id . '</strong>?',
      'modal_footer' => '
      <button type="button" class="btn btn-secondary-native-regular" data-bs-dismiss="modal"> Back</button>
      <button type="submit" class="btn btn-danger">Continue Cancel Order</button>
      ',
    ])
  @elseif ($status == 'paid')
    <a href="/admin/orders/{{ $order_id }}/edit" class="btn btn-success"><i class="fa-solid fa-check"></i> Confirm</a>
  @elseif ($status == 'delivering' OR $status == 'completed')
    <a href="/admin/orders/{{ $order_id }}/edit" class="btn btn-primary"><i class="fa-regular fa-pen-to-square"></i> Edit</a>
  @endif
  </div>
@else
<div>
  <a href="/order/{{ $order_id }}" class="btn btn-info me-1"><i class="fa-solid fa-circle-info"></i> Detail</a>
  @if ($status == 'unpaid')
    <a href="/order/payment/{{ $order_id }}" class="btn btn-success me-1"><i class="fa-regular fa-money-bill-1"></i> Pay</a>
    <a href="" class="btn btn-danger me-1" data-bs-toggle="modal" data-bs-target="#cancelOrder-{{ $order_id }}"><i class="fa-solid fa-xmark"></i> Cancel</a>
    
    @include('partials/modal', [
      'modal_id' => 'cancelOrder-' . $order_id,
      'modal_title' => 'Cancel Order',
      'include_form' => 'true',
      'form_action' => '/order/' . $order_id ,
      'form_method' => 'post', 
      'additional_form_method' => 'delete', 
      'modal_body' => '
      Are you sure to cancel <strong> Order #' . $order_id . '</strong>?',
      'modal_footer' => '
      <button type="button" class="btn btn-secondary-native-regular" data-bs-dismiss="modal"> Back</button>
      <button type="submit" class="btn btn-danger">Continue Cancel Order</button>
      ',
    ])
  @elseif ($status == 'delivering')
    <a href="" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#completeOrder-{{ $order_id }}"><i class="fa-solid fa-check"></i> Complete</a>
    <a href="/order/invoice/{{ $order_id }}" class="btn btn-secondary"><i class="far fa-file-alt"></i> Invoice</a>

    @include('partials/modal', [
      'modal_id' => 'completeOrder-' . $order_id,
      'modal_title' => 'Complete Order',
      'include_form' => 'true',
      'form_action' => '/order/' . $order_id ,
      'form_method' => 'post', 
      'additional_form_method' => 'put', 
      'modal_body' => ' 
      <input type="hidden" value="'. $order_id . '" required>
      <strong>Are you sure to complete Order #' . $order_id . '</strong>? <br> Please make sure you have already received and checked your order. Status reversion cannot be done after the order is completed.',
      'modal_footer' => '
      <button type="button" class="btn btn-secondary-native-regular" data-bs-dismiss="modal"> Back</button>
      <button type="submit" class="btn btn-primary-native-regular">Complete Order</button>
      ',
    ])
  @elseif ($status == 'paid' OR $status == 'completed')
    <a href="/order/invoice/{{ $order_id }}" class="btn btn-secondary"><i class="far fa-file-alt"></i> Invoice</a>
  @endif
</div>
@endif