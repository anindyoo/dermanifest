<style>
  .status-badge {
    padding: 8px 6px;
  }
  .danger-status {
    background-color: #dc3545;
    color: #ffffff;
  }
  .success-status {
      background-color: #198754;
      color: #ffffff;
  }
</style>
@if ($status == 'unpaid')
  <span class="status-badge danger-status fw-bold">{{ ucfirst($status) }}</span>  
@elseif ($status == 'paid')
  <span class="status-badge success-status fw-bold">{{ ucfirst($status) }}</span>  
@endif