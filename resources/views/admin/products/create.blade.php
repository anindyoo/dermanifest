@extends('layouts.admin.header')

@section('content')
<div class="content">
  <h2>Add Product</h2>
  <hr>
  @foreach ($errors->all() as $error)
    <div class="alert alert-danger" role="alert">
      {{ $error }}<br/>
    </div>
  @endforeach
  <form action="/admin/products" method="post" enctype="multipart/form-data">
    @csrf
    <div class="form-group mb-3">
      <label class="form-label">Product Name</label>
      <input id="name_product" type="text" class="form-control" name="name_product" value="{{ old('name_product') }}" required>
    </div>
    <div class="form-group mb-3">
      <label class="form-label">Slug</label>
      <input id="slug" type="text" class="form-control" name="slug" value="{{ old('slug') }}" required readonly>
    </div>
    <div class="form-group mb-3">
      <label class="form-label">Product Category</label> <br>
      <select class="form-select" name="category_id" required>
        <option value="" hidden disabled selected>Select Category</option>
          @foreach ($categories_data as $category)
            <option value="{{ $category->id }}">{{ $category->name_category }}</option>              
          @endforeach
      </select>
	  </div>
    <div class="form-group mb-3">
      <label class="form-label">Price</label>
      <input type="text" class="form-control" name="price" value="{{ old('price') }}" required>
    </div>
    <div class="form-group mb-3">
      <label class="form-label">Discounted Price (Leave it blank if not available)</label>
      <input type="text" class="form-control" name="discount_price" value="{{ old('discount_price') }}">
    </div>
    <div class="form-group mb-3">
      <label class="form-label">Stock</label>
      <input type="text" class="form-control" name="stock" value="{{ old('stock') }}" required>
    </div>
    <div class="form-group mb-3">
      <label class="form-label">Net Weight (gram)</label>
      <input type="text" class="form-control" name="net_weight" value="{{ old('net_weight') }}" required>
    </div>
    <div class="form-group mb-3">
      <label class="form-label">Gross Weight (For Delivery, in gram)</label>
      <input type="text" class="form-control" name="gross_weight" value="{{ old('gross_weight') }}" required>
    </div>
    <div class="form-group mb-3">
      <label class="form-label">Description</label>
      <input id="description" type="hidden" name="description" value="{{ old('description') }}" required>
      <trix-editor input="description"></trix-editor>
    </div>
    <div class="form-group mb-3">
      <label class="form-label">Instruction</label>
      <input id="instruction" type="hidden" name="instruction" value="{{ old('instruction') }}" required>
      <trix-editor input="instruction"></trix-editor>
    </div>
    <div class="form-group mb-3">
      <label class="form-label">Ingredients</label>
      <input id="ingredients" type="hidden" name="ingredients" value="{{ old('ingredients') }}" required>
      <trix-editor input="ingredients"></trix-editor>
    </div>
    <div class="form-group mb-3">
      <label class="form-label"><h4>Pictures</h4></label>
      <p>Main Picture (For Product List Cover Display)</p>
      <div class="picture-input">
        <input type="file" class="form-control" name="pictures[]" required>			
        <p class="mt-3" >Add Additional Pictures (Max. 6 Pictures)</p>
      </div>
      <div class="pic-btn mt-3">
        <span id="add-input" class="btn btn-primary-native-regular add-input" style="width: 60px">
          <i class="fa fa-plus"></i>
        </span>
        <span id="remove-input" class="btn btn-outline-danger remove-input" style="width: 60px">
          <i class="fa fa-minus"></i>
        </span>
      </div>
    </div>
    <div class="text-end">
      <button type="submit" class="btn btn-primary-native"><span class="fa-solid fa-circle-check"></span> Add Product</button>
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

  $(document).ready(function () {
    let count = 0;

    $(".add-input").on("click", function(){
      if (count < 6) {
        $(".picture-input").append(`<input type="file" id="picture-input-${count}" class="form-control mt-3" name="pictures[]">`);
        count++;

        if (count === 6) {
          $("#add-input").hide();
        } else {
          $("#remove-input").show();
        }
      }
    });

    $(".remove-input").on("click", function(){
      if (count > 0) {
        $(`#picture-input-${count-1}`).remove();
        count--;

        if (count === 0) {
          $("#remove-input").hide();
        } else {
          $("#add-input").show();
        }
      }
 		});

    if (count < 1) {
      $("#remove-input").hide();
    } else if (count > 0) {
      $("#remove-input").show();
    }
  });
</script>
@endsection