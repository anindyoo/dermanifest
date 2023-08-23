@extends('layouts.admin.header')

@section('content')
<div class="content">
  <h2>Message Detail</h2>
  <hr>
  <div>
    @if(session()->has('success'))
      @include('partials/alert', [
        'status' => 'success',
        'message' => session('success'),
      ])
    @endif
  </div>
  <div class="table-responsive">
    <table class="table table-bordered table-striped table-hover table-header-on-left">
      <tbody>
        <tr>
          <th>Message Id</th>
          <td>{{ $message_data->id }}</td>
        </tr>          
        <tr>
          <th>Customer Id</th>
          <td><a href="/admin/customers/{{ $message_data->customer_id }}" class="text-primary-native">{{ $message_data->customer_id }} <i class="fas fa-external-link-alt fa-xs"></i></a></td>
        </tr>          
        <tr>
          <th>Email</th>
          <td>{{ $message_data->email }}</td>
        </tr>          
        <tr>
          <th>Phone</th>
          <td>{{ $message_data->phone }}</td>
        </tr>          
        <tr>
          <th>Date</th>
          <td>{{ $message_data->created_at }} WIB</td>
        </tr>          
        <tr>
          <th>Status</th>
          <td>
            @if ($message_data->is_read)
              <span class="status-badge completed-status fw-bold"><i class="fas fa-check-circle"></i> Read</span>  
            @else
              <span class="status-badge warning-status fw-bold"><i class="fas fa-exclamation-circle"></i> Unread</span>  
            @endif
          </td>
        </tr>          
        <tr>
          <th>Subject</th>
          <td><strong>{{ $message_data->subject }}</strong></td>
        </tr>          
        <tr>
          <th>Message</th>
          <td>{!! $message_data->message !!}</td>
        </tr>          
      </tbody>
    </table>
  </div>
  <form action="/admin/messages/{{ $message_data->id }}" method="post">
    @csrf
    @method('put')
    <div class="text-end">
      <input type="hidden" name="id" value="{{  $message_data->id  }}">
      @if ($message_data->is_read == 0)
        <input type="hidden" name="is_read" value="1">
        <button type="submit" class="btn btn-primary-native"><span class="far fa-edit"></span> Mark as Read</button>
      @else
        <input type="hidden" name="is_read" value="0">
        <button type="submit" class="btn btn-primary-native"><span class="far fa-edit"></span> Mark as Unread</button>
      @endif
    </div>
  </form>
</div>
@endsection