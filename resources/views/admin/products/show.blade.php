@extends('layouts.admin.header')

@section('content')
<div class="content">
  <h2>Product Detail</h2>
  <hr>
  <table class="table table-bordered table-striped table-hover table-header-on-left">
    <tbody>
      <tr>
        <th>Id</th>
        <td>{{ $product_data->id }}</td>
      </tr>
      <tr>
        <th>Name</th>
        <td>{{ $product_data->name_product }}</td>
      </tr>
      <tr>
        <th>slug</th>
        <td>{{ $product_data->slug }}</td>
      </tr>
      <tr>
        <th>Category</th>
        <td>{{ $category_name }}</td>
      </tr>
      <tr>
        <th>Price</th>
        <td>Rp{{ number_format($product_data->price,0,',','.') }},-</td>
      </tr>
      <tr>
        <th>Discount Price</th>
        <td>Rp{{ number_format($product_data->discount_price,0,',','.') }},-</td>
      </tr>
      <tr>
        <th>Stock</th>
        <td>{{ $product_data->stock }}</td>
      </tr>
      <tr>
        <th>Neto</th>
        <td>{{ $product_data->net_weight }} gr</td>
      </tr>
      <tr>
        <th>Gross Weight</th>
        <td>{{ $product_data->gross_weight }} gr</td>
      </tr>
      <tr>
        <th>Description</th>
        <td>{!! $product_data->description !!}</td>
      </tr>
      <tr>
        <th>Instruction</th>
        <td>{!! $product_data->instruction !!}</td>
      </tr>
      <tr>
        <th>Ingredients</th>
        <td>{!! $product_data->ingredients !!}</td>
      </tr>
      <tr>
        <th>Created at</th>
        <td>{!! $product_data->created_at !!}</td>
      </tr>
    </tbody>
  </table>

  <h3 class="mt-20px mb-3">Pictures</h3>
  <div class="row">
    @foreach ($pictures_data as $pic)
      <div class="col-md-3">
        <img src="{{ asset("storage/products/{$pic->name_picture}") }}" width="80%" height="auto"> <br>
        <p class="text-break">
          <strong>Picture {{ $loop->iteration }}</strong>: {{ $pic->name_picture }}
        </p>
      </div>
    @endforeach
  </div>
</div>
@endsection