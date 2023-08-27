@extends('layouts.admin.header')

@section('content')
<div class="content">
  <h2>Admin Log Activities Detail</h2>
  <hr>
  <div>
    @if(session()->has('success'))
      @include('partials/alert', [
        'status' => 'success',
        'message' => session('success'),
      ])
    @endif
  </div>
  <h5 class="fw-bold mb-2">Admin Detail</h5>
  <table class="table table-bordered table-striped table-hover table-header-on-left">
    <tbody>
      <tr>
        <th>Customer Id</th>
        <td>{{ $admin_data->id }}</td>
      </tr>
      <tr>
        <th>Name</th>
        <td>{{ $admin_data->name_admin }}</td>
      </tr>
    </tbody>
  </table>
  <h5 class="fw-bold mb-2">Log Activities</h5>
  <div class="table-wrapper table-responsive">
    <table class="table table-bordered table-striped table-hover">
      <thead>
        <tr>
          <th>No.</th>
          <th>Log Id</th>
          <th>Activity</th>
          <th>URL</th>
          <th>Method</th>
          <th>Ip</th>
          <th>User Agent</th>
          <th>Date Created</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($log_data as $log)
          <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $log->id }}</td>        
            <td>{{ $log->activity }}</td>
            <td>{{ $log->url }}</td>
            <td>{{ $log->method }}</td>
            <td>{{ $log->ip }}</td>
            <td>{{ $log->agent }}</td>
            <td>{{ $log->created_at }} WIB</td>
          </tr>
        @endforeach
      </tbody>
    </table>
  </div>
</div>
@endsection