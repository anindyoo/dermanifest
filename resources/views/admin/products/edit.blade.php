@extends('layouts.admin.header')

@section('content')
<div class="content">
  <h2>Edit Product</h2>
  <hr>
  @foreach ($errors->all() as $error)
    <div class="alert alert-danger" role="alert">
      {{ $error }}<br/>
    </div>
  @endforeach
  <form action="/admin/products/{{ $product_data->id }}" method="post" enctype="multipart/form-data">
    @method('put')
    @csrf
    <div class="form-group mb-3">
      <label class="form-label">Product Id</label>
      <input type="text" class="form-control" name="name_category" value="{{ $product_data->id }}" readonly disabled>
    </div>
    <div class="form-group mb-3">
      <label class="form-label">Product Name</label>
      <input id="name_product" type="text" class="form-control" name="name_product" value="{{ old('name_product', $product_data->name_product) }}" required>
    </div>
    <div class="form-group mb-3">
      <label class="form-label">Slug</label>
      <input id="slug" type="text" class="form-control" name="slug" value="{{ old('slug', $product_data->slug) }}" required readonly>
    </div>
    <div class="form-group mb-3">
      <label class="form-label">Product Category</label> <br>
      <select class="form-select" name="category_id" required>
          @foreach ($categories_data as $category)
            @if ($category->id == $product_data->category_id)
              <option value="{{ $category->id }}" selected>{{ $category->name_category }}</option>              
            @else
              <option value="{{ $category->id }}">{{ $category->name_category }}</option>              
            @endif
          @endforeach
      </select>
	  </div>
    <div class="form-group mb-3">
      <label class="form-label">Price</label>
      <input type="text" class="form-control" name="price" value="{{ old('price', $product_data->price) }}" required>
    </div>
    <div class="form-group mb-3">
      <label class="form-label">Discounted Price (Leave it blank if not available)</label>
      <input type="text" class="form-control" name="discount_price" value="{{ old('discount_price', $product_data->discount_price) }}">
    </div>
    <div class="form-group mb-3">
      <label class="form-label">Stock</label>
      <input type="text" class="form-control" name="stock" value="{{ old('stock', $product_data->stock) }}" required>
    </div>
    <div class="form-group mb-3">
      <label class="form-label">Net Weight (gram)</label>
      <input type="text" class="form-control" name="net_weight" value="{{ old('net_weight', $product_data->net_weight) }}" required>
    </div>
    <div class="form-group mb-3">
      <label class="form-label">Gross Weight (For Delivery, in gram)</label>
      <input type="text" class="form-control" name="gross_weight" value="{{ old('gross_weight', $product_data->gross_weight) }}" required>
    </div>
    <div class="form-group mb-3">
      <label class="form-label">Description</label>
      <input id="description" type="hidden" name="description" value="{{ old('description', $product_data->description) }}" required>
      <trix-editor input="description"></trix-editor>
    </div>
    <div class="form-group mb-3">
      <label class="form-label">Instruction</label>
      <input id="instruction" type="hidden" name="instruction" value="{{ old('instruction', $product_data->instruction) }}" required>
      <trix-editor input="instruction"></trix-editor>
    </div>
    <div class="form-group mb-3">
      <label class="form-label">Ingredients</label>
      <input id="ingredients" type="hidden" name="ingredients" value="{{ old('ingredients', $product_data->ingredients) }}" required>
      <trix-editor input="ingredients"></trix-editor>
    </div>
    <div class="form-group mb-3">
      <label class="form-label"><h4>Edit Main Picture</h4></label>
      <p></p>
      <img src="{{ asset("storage/products/$product_data->main_picture") }}" class="mb-3" width="200vw" height="auto" alt="Product main picture">
      <div class="picture-input">
        <label for="main-picture-input" class="form-label">Upload New Main Picture</label>
        <input id="main-picture-input" type="file" class="form-control" name="main_picture">			
      </div>
    </div>
    <div class="text-end">
      <button type="submit" class="btn btn-primary-native"><span class="fa-solid fa-circle-check"></span> Update Product</button>
    </div>
  </form>
</div>
@endsection

@section('js_code')
<script>
  const name_product = document.querySelector('#name_product');
  const slug = document.querySelector('#slug');

  var rand = Math.floor(1000 + Math.random() * 9000);

  name_product.addEventListener("keyup", function() {
    let preslug = name_product.value;
    preslug = preslug.replace(/ /g,"-");
    slug.value = preslug.toLowerCase() + '-' +rand;
  });
</script>
@endsection