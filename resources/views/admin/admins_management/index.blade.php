@extends('layouts.admin.header')

@section('content')
<div class="content">
  <h2>Admins Management</h2>
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
    <a href="/admin/admins_management/create" class="btn btn-primary-native mb-3"><span class="fa-solid fa-plus me-2"></span>Add New Admin</a>
  </div>
  <div class="table-wrapper table-responsive">
    <table class="table table-bordered table-striped table-hover">
      <thead>
        <tr>
          <th>No.</th>
          <th>Admin Id</th>
          <th>Name</th>
          <th>Email</th>
          <th>Date Created</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($admins_data as $admin)
          <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $admin->id }}</td>
            <td>{{ $admin->name_admin }}</td>
            <td>{{ $admin->email }}</td>
            <td>{{ $admin->created_at }}</td>
            <td>
              <a href="/admin/admins_management/log_activity/{{ $admin->id }}" class="btn btn-secondary me-1"><i class="fas fa-history"></i> Log</a>
              @if ($admin->email != 'dermanifest@gmail.com')
              <a href="" class="btn btn-danger me-1" data-bs-toggle="modal" data-bs-target="#deleteAdmin-{{ $admin->id }}"><i class="fa-solid fa-xmark"></i> Delete</a>                  
              @endif
            </td>
          </tr>
          @include('partials/modal', [
            'modal_id' => 'deleteAdmin-' . $admin->id,
            'modal_title' => 'Delete Admin',
            'include_form' => 'true',
            'form_action' => '/admin/admins_management/' . $admin->id,
            'form_method' => 'post', 
            'additional_form_method' => 'delete', 
            'modal_body' => '
            <input type="hidden" name="id" value="' . $admin->id . '" required>
            Are you sure to delete Admin: <strong>' . $admin->name_admin . '</strong>?',
            'modal_footer' => '
            <button type="button" class="btn btn-secondary-native-regular" data-bs-dismiss="modal"> Back</button>
            <button type="submit" class="btn btn-danger">Continue Delete Admin</button>
            ',
          ])
        @endforeach
      </tbody>
    </table>
  </div>
</div>
@endsection