@extends('layouts.admin.header')

@section('content')
<div class="content">
  <h2>Add Category</h2>
  <hr>
  <form action="/admin/categories" method="post">
    @csrf
    <div class="form-group mb-3">
      <label class="form-label">Category Name</label>
      <input type="text" class="form-control" name="name_category" required>
    </div>
    <div class="form-group mb-3">
      <label class="form-label">Description</label>
      <textarea type="text" class="form-control" name="description_category" required></textarea>
    </div>
    <div class="text-end">
      <button type="submit" class="btn btn-primary-native"><span class="fa-solid fa-circle-check"></span> Add Category</button>
    </div>
  </form>
</div>
@endsection