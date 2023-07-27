@extends('layouts.admin.header')

@section('content')
<div class="content">
  <h2>Update Category</h2>
  <hr>
  <form action="/admin/categories/{{ $category_data->id }}" method="post">
    @method('put')
    @csrf
    <div class="form-group mb-3">
      <label class="form-label">Category Name</label>
      <input type="text" class="form-control" name="name_category" value="{{ $category_data->name_category }}" required>
    </div>
    <div class="form-group mb-3">
      <label class="form-label">Description</label>
      <textarea type="text" class="form-control" name="description_category" required>{{ $category_data->description_category }}</textarea>
    </div>
    <div class="text-end">
      <button type="submit" class="btn btn-primary-native"><span class="fa-solid fa-circle-check"></span> Update Category</button>
    </div>
  </form>
</div>
@endsection