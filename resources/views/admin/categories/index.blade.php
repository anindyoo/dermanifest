@extends('layouts.admin.header')

@section('content')
<div class="content">
  <h2>Categories</h2>
  <hr>
  <div>
    @if(session()->has('success'))
      <div>
        <div class="alert alert-success" role="alert">
          {!! session('success') !!}
        </div>
      </div>
    @endif
  </div>
  <div>
    <a href="/admin/categories/create" class="btn btn-primary-native mb-3"><span class="fa-solid fa-plus me-2"></span>Add Category</a>
  </div>
  <div class="table-wrapper" style="overflow-x: auto;">
    <table class="table table-bordered table-striped table-hover">
      <thead>
        <tr>
          <th>No.</th>
          <th>Id Category</th>
          <th>Name</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($categories_data as $category)
          <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $category->id }}</td>
            <td>{{ $category->name_category }}</td>
            <td>
              <a href="/admin/categories/{{ $category->id }}/edit" class="btn btn-primary">
                <span><i class="fa-solid fa-pen-to-square me-1"></i></span>Update
              </a>
              <a class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteCategoryModal-{{ $category->id }}">
                <span><i class="fa-regular fa-trash-can me-1"></i></span>Delete
              </a>
            </td>
          </tr>          
        @endforeach
      </tbody>
    </table>
  </div>
</div>

{{-- DELETE CATEGORY MODAL --}}
@if (count($categories_data) > 0)
@foreach($categories_data as $category)
  @include('partials/modal', [
    'modal_id' => 'deleteCategoryModal-' . $category->id,
    'modal_title' => 'Delete Category',
    'include_form' => 'true',
    'form_action' => '/admin/categories/' . $category->id ,
    'form_method' => 'post', 
    'additional_form_method' => 'delete', 
    'modal_body' => 'Are you sure to delete category: <strong>' . $category->name_category . '</strong>?',
    'modal_footer' => '
    <button type="button" class="btn btn-secondary-native-regular" data-bs-dismiss="modal">Cancel Delete</button>
    <button type="submit" class="btn btn-danger"><span class="fa-regular fa-trash-can me-1"></span>Delete Category</button>
    ',
  ])
@endforeach      
@endif
@endsection