@extends('layouts.admin.header')

@section('content')
<div class="content">
  <h2>Products</h2>
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
    <a href="/admin/products/create" class="btn btn-primary-native mb-3"><span class="fa-solid fa-plus me-2"></span>Add Product</a>
  </div>
  <div class="table-wrapper" style="overflow-x: auto;">
    <table class="table table-bordered table-striped table-hover">
      <thead>
        <tr>
          <th>No.</th>
          <th>Id</th>
          <th>Picture</th>
          <th>Name</th>
          <th>Category</th>
          <th>Price</th>
          <th>Stock</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
          <tr>
            <td>1</td>
            <td>Id 1</td>
            <td>Pic 1</td>
            <td>Name 1</td>
            <td>Category 1</td>
            <td>10000</td>
            <td>5</td>
            <td>
              <a href="" class="btn btn-info text-white">
                <span><i class="fa-regular fa-pen-to-square me-1"></i></span>Detail
              </a>
              <a href="" class="btn btn-primary">
                <span><i class="fa-regular fa-pen-to-square me-1"></i></span>Update
              </a>
              <a href="" class="btn btn-success">
                <span><i class="fa-regular fa-pen-to-square me-1"></i></span>Pictures
              </a>
              <a class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteProductModal-">
                <span><i class="fa-regular fa-trash-can me-1"></i></span>Delete
              </a>
            </td>
          </tr>          
      </tbody>
    </table>
  </div>
</div>

@endsection