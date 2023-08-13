@if ($status == 'unpaid')
  <span class="status-badge danger-status fw-bold">{{ ucfirst($status) }}</span>  
@elseif ($status == 'paid')
  <span class="status-badge success-status fw-bold">{{ ucfirst($status) }}</span>  
@endif