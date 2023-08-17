@extends('layouts.admin.header')

@section('content')
<div class="content">
  <h2>Customers Management</h2>
  <hr>
  <div>
    @if(session()->has('success'))
      @include('partials/alert', [
        'status' => 'success',
        'message' => session('success'),
      ])
    @endif
  </div>
  <div class="table-wrapper table-responsive">
    <table class="table table-bordered table-striped table-hover">
      <thead>
        <tr>
          <th>No.</th>
          <th>Customer Id</th>
          <th>Name</th>
          <th>Email</th>
          <th>Phone</th>
          <th>Transactions Total</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($customers_data as $customer)
          <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $customer->id }}</td>
            <td>{{ $customer->name_customer }}</td>
            <td>{{ $customer->email }}</td>
            <td>@if ($customer->phone != null) {{ $customer->phone }} @else - @endif </td>
            <td>{{ $customer->transactions_total }}</td>
            <td>
              <a href="/admin/customers/{{ $customer->id }}" class="btn btn-info text-white me-1"><i class="fa-solid fa-circle-info"></i> Detail</a>
              <a href="" class="btn btn-danger me-1" data-bs-toggle="modal" data-bs-target="#deleteCustomer-{{ $customer->id }}"><i class="fa-solid fa-xmark"></i> Delete</a>
            </td>
          </tr>
          @include('partials/modal', [
          'modal_id' => 'deleteCustomer-' . $customer->id,
          'modal_title' => 'Delete Customer',
          'include_form' => 'true',
          'form_action' => '/admin/customers/' . $customer->id ,
          'form_method' => 'post', 
          'additional_form_method' => 'delete', 
          'modal_body' => '
          Are you sure to delete Customer: <strong>' . $customer->name_customer . '</strong>?',
          'modal_footer' => '
          <button type="button" class="btn btn-secondary-native-regular" data-bs-dismiss="modal"> Back</button>
          <button type="submit" class="btn btn-danger">Continue Delete Customer</button>
          ',
        ])
        @endforeach
      </tbody>
    </table>
  </div>
</div>
@endsection