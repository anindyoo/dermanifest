@if ($status == 'unpaid')
  <span class="text-danger fw-bold">{{ ucfirst($status) }}</span>  
@elseif ($status == 'paid')
  <span class="text-success fw-bold">{{ ucfirst($status) }}</span>
@elseif ($status == 'delivering')
  <span class="text-primary fw-bold">{{ ucfirst($status) }}</span>
@elseif ($status == 'completed')
  <span class="text-primary-native fw-bold">{{ ucfirst($status) }}</span>
@endif