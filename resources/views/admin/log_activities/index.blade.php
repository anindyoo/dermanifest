@extends('layouts.admin.header')

@section('content')
<div class="content">
  <h2>Log Activities</h2>
  <hr>
  <div>
    @if(session()->has('success'))
      @include('partials/alert', [
        'status' => 'success',
        'message' => session('success'),
      ])
    @endif
  </div>
  <div>
    <h5 class="fw-bold mb-2">Logging Feature Status</h5>
    @if ($latest_log->role == 'disabled')
    <h6 class="text-danger fw-bold mb-3">Disabled</h6>            
    @else
    <h6 class="text-success fw-bold mb-3">Enabled</h6>        
    @endif

    <form action="/admin/log_activities" method="post">	
      @csrf
      @if ($latest_log->role == 'disabled')
      <input type="hidden" name="role" value="enabled" required>
      <button type="submit" class="btn btn-primary-native mb-3"><span class="fa-solid fa-power-off me-2"></span>Enable Logging</button>      
      @else
      <button type="button" class="btn btn-danger mb-3" style="padding: 12px 24px; border: 2px solid #dc3545" data-bs-toggle="modal" data-bs-target="#disable-logging"><span class="fa-solid fa-power-off me-2"></span><strong>Disable Logging</strong></button>
      @include('partials/modal', [
        'modal_id' => 'disable-logging',
        'modal_title' => 'Disable Logging Feature',
        'include_form' => 'true',
        'form_action' => '/admin/log_activities/',
        'form_method' => 'post', 
        'modal_body' => '
        Are you sure to disable Logging feature?',
        'modal_footer' => '
        <input type="hidden" name="role" value="disabled" required>
        <button type="button" class="btn btn-secondary-native-regular" data-bs-dismiss="modal"> Back</button>
        <button type="submit" class="btn btn-danger"><strong>Continue Disable Logging</strong></button>
        ',
      ])    
      @endif
    </form>
  </div>
  <div class="table-wrapper table-responsive">
    <table class="table table-bordered table-striped table-hover">
      <thead>
        <tr>
          <th>No.</th>
          <th>Log Id</th>
          <th>User Id</th>
          <th>Role</th>
          <th>Activity</th>
          <th>URL</th>
          <th>Method</th>
          <th>Ip</th>
          <th>User Agent</th>
          <th>Date Created</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($logs_data as $log)
          <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $log->id }}</td>
            <td>{{ $log->user_id }} @empty($log->user_id) guest @endempty</td>
            <td>{{ $log->role }}</td>
            <td>{{ $log->activity }}</td>
            <td>{{ $log->url }}</td>
            <td>{{ $log->method }}</td>
            <td>{{ $log->ip }}</td>
            <td>{{ $log->agent }}</td>
            <td>{{ $log->created_at }} WIB</td>
            <td><a href="" class="btn btn-danger me-1" data-bs-toggle="modal" data-bs-target="#deleteLog-{{ $log->id }}"><i class="fa-solid fa-xmark"></i> Delete</a></td>
          </tr>
          @include('partials/modal', [
            'modal_id' => 'deleteLog-' . $log->id,
            'modal_title' => 'Delete Log Activity',
            'include_form' => 'true',
            'form_action' => '/admin/log_activities/' . $log->id ,
            'form_method' => 'post', 
            'additional_form_method' => 'delete', 
            'modal_body' => '
            Are you sure to delete Log Activity: <strong>#' . $log->id . '</strong>?',
            'modal_footer' => '
            <button type="button" class="btn btn-secondary-native-regular" data-bs-dismiss="modal"> Back</button>
            <button type="submit" class="btn btn-danger">Continue Delete Log Activity</button>
            ',
          ])
        @endforeach
      </tbody>
    </table>
  </div>
</div>
@endsection