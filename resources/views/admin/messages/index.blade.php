@extends('layouts.admin.header')

@section('content')
<div class="content">
  <h2>Admin messages</h2>
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
          <th>Message Id</th>
          <th>Customer Id</th>          
          <th>Subject</th>
          <th>Status</th>
          <th>Date</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($messages_data as $message)
          <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $message->id }}</td>
            <td><a href="/admin/customers/{{ $message->customer_id }}" class="text-primary-native">{{ $message->customer_id }} <i class="fas fa-external-link-alt fa-xs"></i></a></td>
            <td>{{ $message->subject }}</td>
            <td>
              @if ($message->is_read)
                <span class="status-badge completed-status fw-bold"><i class="fas fa-check-circle"></i> Read</span>  
              @else
                <span class="status-badge warning-status fw-bold"><i class="fas fa-exclamation-circle"></i> Unread</span>  
              @endif
            </td>
            <td>{{ $message->created_at }}</td>
            <td>            
              <a href="/admin/messages/{{ $message->id }}" class="btn btn-info text-white me-1"><i class="fa-solid fa-circle-info"></i> Detail</a>
              <a href="" class="btn btn-danger me-1" data-bs-toggle="modal" data-bs-target="#deleteMessage-{{ $message->id }}"><i class="fa-solid fa-xmark"></i> Delete</a>                  
            </td>
          </tr>
          @include('partials/modal', [
            'modal_id' => 'deleteMessage-' . $message->id,
            'modal_title' => 'Delete Message',
            'include_form' => 'true',
            'form_action' => '/admin/messages/' . $message->id,
            'form_method' => 'post', 
            'additional_form_method' => 'delete', 
            'modal_body' => '
            <input type="hidden" name="id" value="' . $message->id . '" required>
            Are you sure to delete <strong>Message #' . $message->id . '</strong>?',
            'modal_footer' => '
            <button type="button" class="btn btn-secondary-native-regular" data-bs-dismiss="modal"> Back</button>
            <button type="submit" class="btn btn-danger">Continue Delete Message</button>
            ',
          ])
        @endforeach
      </tbody>
    </table>
  </div>
</div>
@endsection