@extends('layouts.admin.header')

@section('content')
<div class="content">
  @if(session()->has('success'))
    <div class="home-alert">
      <div class="alert alert-success" role="alert">
        {{ session('success') }}
      </div>
    </div>
  @endif
  <h2>Top Products Management</h2>
  <hr>
  <form action="/admin/top_products" method="post">
    @csrf
    @forelse ($top_products_data as $top_product)
    <div class="form-group mb-4">
      <label class="form-label"><h5>Top Product #{{ $loop->iteration }}</h5></label>
      @if ($top_product->product_id != null)
      @foreach ($products_data as $product)
        @if ($product->id == $top_product->product_id)
        <p class="mb-1">Product: <strong>{{ $product->name_product }}</strong></p>                         
        @endif
      @endforeach      
      @else
      <p class="mb-1">Product has not been set.</p>
      @endif
      <select class="form-select" name="product_id[]" aria-label="Default select example">
        <option value="" hidden selected>Select Product</option>
        <option value="">-Unset Product-</option>
        @foreach ($products_data as $product)
          @if ($product->id == $top_product->product_id)
            <option value="{{ $product->id }}" selected>{{ $product->name_product }}</option>              
          @else
            <option value="{{ $product->id }}">{{ $product->name_product }}</option>              
          @endif
        @endforeach
      </select>
      <input type="hidden" class="form-control" name="position[]" value="{{ $loop->iteration }}" required>
    </div>

    @empty
    @for ($i = 0; $i < 5; $i++)
    <div class="form-group mb-4">
      <label class="form-label"><h5>Product #{{ $i }}</h5></label>
      <p class="mb-1">Product has not been set.</p>
      <select class="form-select" name="product_id[]" aria-label="Default select example">
        <option value="" hidden selected>Select Product</option>
        @foreach ($products_data as $product)
          <option value="{{ $product->id }}">{{ $product->name_product }}</option>                  
        @endforeach
      </select>
      <input type="hidden" class="form-control" name="position[]" value="{{ $i }}" required>
    </div>
    @endfor  
    @endforelse
    <div class="text-end">
      <button type="submit" class="btn btn-primary-native"><span class="fa-solid fa-circle-check"></span> Save Top Products</button>
    </div>
  </form>
</div>
@endsection

@section('js_code')
@endsection