@extends('layouts.admin.header')

@section('content')
<div class="content">
  <h2>Orders Management</h2>
  <hr>
  <div>
    @if(session()->has('success'))
      @include('partials/alert', [
        'status' => 'success',
        'message' => session('success'),
      ])
    @endif
  </div>
  <label for="select-status" class="form-label">Filter Order</label>
  <select id="filter-order" class="form-select mb-3">
    <option value="all-table">All Order</option>
    <option value="unpaid-table">Unpaid</option>
    <option value="paid-table">Paid</option>
    <option value="delivering-table">Delivering</option>
    <option value="completed-table">Completed</option>
  </select>
  <div id="all-table" class="table-wrapper">
    @include('partials.order_table', ['orders' => $orders_data, 'status' => 'all', 'role' => 'admin'])
  </div>
  <div id="unpaid-table" class="table-wrapper d-none">
    @include('partials.order_table', ['orders' => $orders_data, 'status' => 'unpaid', 'role' => 'admin'])
  </div>
  <div id="paid-table" class="table-wrapper d-none">
    @include('partials.order_table', ['orders' => $orders_data, 'status' => 'paid', 'role' => 'admin'])
  </div>
  <div id="delivering-table" class="table-wrapper d-none">
    @include('partials.order_table', ['orders' => $orders_data, 'status' => 'delivering', 'role' => 'admin'])
  </div>
  <div id="completed-table" class="table-wrapper d-none">
    @include('partials.order_table', ['orders' => $orders_data, 'status' => 'completed', 'role' => 'admin'])
  </div>
</div>
@endsection
@section('js_code')
<script>
$(document).ready(function() {
  $('#filter-order').change(function() {
    $('.table-wrapper').addClass('d-none');
    $('#' + this.value).removeClass('d-none');
  });
});
</script>
@endsection