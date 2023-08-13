@if ($status == 'unpaid')
  <span class="text-danger fw-bold">{{ ucfirst($status) }}</span>  
@elseif ($status == 'paid')
  <span class="text-success fw-bold">{{ ucfirst($status) }}</span>  
@endif