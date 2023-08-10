@if ($status == 'unpaid')
  <div class="">
    <a href="/order/{{ $order_id }}" class="btn btn-info"><i class="fa-solid fa-circle-info"></i> Detail</a>
    <a href="" class="btn btn-danger me-2" data-bs-toggle="modal" data-bs-target="#cancelOrder-{{ $order_id }}"><i class="fa-solid fa-xmark"></i> Cancel</a>
  </div>
  
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
@elseif (3 ==4)
    ''
@endif