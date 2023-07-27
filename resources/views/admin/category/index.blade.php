@extends('layouts.admin.header')

@section('content')
<div class="content">
  <h2>Categories</h2>
  <hr>
  <div>
    @if(session()->has('success'))
      <div>
        <div class="alert alert-success" role="alert">
          {{ session('success') }}
        </div>
      </div>
    @endif
  </div>
  <div>
    <a href="" class="btn btn-primary-native mb-3"><span class="fa-solid fa-plus me-2"></span>Add Category</a>
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
        <tr>
          <td>1</td>
          <td>Id Category 1</td>
          <td>Name 1</td>
          <td>
            <a href="" class="btn btn-primary">
              <span><i class="fa-regular fa-pen-to-square me-1"></i></span>Update
            </a>
            <a class="btn btn-danger" data-toggle="modal" data-target="#modal">
              <span><i class="fa-regular fa-trash-can me-1"></i></span>Delete
            </a>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</div>
@endsection