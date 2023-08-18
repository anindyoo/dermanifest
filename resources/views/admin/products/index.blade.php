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
        @foreach ($products_data as $product)
          <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $product->id }}</td>
          <td><img src="{{ asset("storage/products/{$product->main_picture}") }}" width="120" height="auto"></td>
            <td>{{ $product->name_product }}</td>
            <td>{{ $product->category_name }}</td>
            <td>Rp{{ number_format($product->price,0,',','.') }},-</td>
            <td>{{ $product->stock }} pc(s)</td>
            <td>
              <a href="/admin/products/{{ $product->id }}" class="btn btn-info text-white">
                <span><i class="fa-solid fa-circle-info me-1"></i></span>Detail
              </a>
              <a href="/admin/products/{{ $product->id }}/edit" class="btn btn-primary">
                <span><i class="fa-regular fa-pen-to-square me-1"></i></span>Update
              </a>
              <a href="/admin/pictures/{{ $product->id }}" class="btn btn-success">
                <span><i class="far fa-images me-1"></i></span>Pictures
              </a>
              <a class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteProductModal-{{ $product->id }}">
                <span><i class="fa-regular fa-trash-can me-1"></i></span>Delete
              </a>
            </td>
          </tr>       
          
          @include('partials/modal', [
            'modal_id' => 'deleteProductModal-' . $product->id,
            'modal_title' => 'Delete Product',
            'include_form' => 'true',
            'form_action' => '/admin/products/' . $product->id ,
            'form_method' => 'post', 
            'additional_form_method' => 'delete', 
            'modal_body' => 'Are you sure to delete address: <strong>' . $product->name_product . '</strong>?',
            'modal_footer' => '
            <button type="submit" class="btn btn-outline-danger"><span class="fa-regular fa-trash-can me-1"></span>Delete Product</button>
            <button type="button" class="btn btn-primary-native-regular" data-bs-dismiss="modal"><span class="fa-solid fa-pen-to-square me-1"></span>Cancel Delete</button>
            ',
          ])
        @endforeach
      </tbody>
    </table>
  </div>
</div>

@endsection