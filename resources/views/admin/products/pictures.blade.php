@extends('layouts.admin.header')

@section('content')
<div class="content">
  <h2>Manage Product Pictures</h2>
  <hr>
  @foreach ($errors->all() as $error)
    <div class="alert alert-danger" role="alert">
      {!! $error !!}<br/>
    </div>
  @endforeach
  @if(session()->has('success'))
    <div class="home-alert">
      <div class="alert alert-success" role="alert">
        {!! session('success') !!}
      </div>
    </div>
  @endif
  <table class="table table-bordered table-striped table-hover table-header-on-left">
    <tbody>
      <tr>
        <th>Product Id</th>
        <td>{{ $product_data->id }}</td>
      </tr>
      <tr>
        <th>Product Name</th>
        <td>{{ $product_data->name_product }}</td>
      </tr>
    </tbody>
  </table>

  <h3 class="mt-20px">Pictures</h3>
  <div class="row justify-content-start mt-3 align-items-start">
    <div class="d-flex flex-column col-md-2 me-3 border border-2 rounded-3 mb-3 p-2">
      <h4 class="mb-2">Main Picture</h4>
      <img src="{{ asset("storage/products/$product_data->main_picture") }}">
      <p class="text-break">{{ $product_data->main_picture }}</p>
    </div>

    @foreach ($product_pictures_data as $key => $pic)
    @if ($key > 0)
      <div class="d-flex flex-column col-md-2 me-3 border border-2 rounded-3 mb-3 p-2">
        <h4 class="mb-2">Additional Picture #{{ $loop->iteration - 1 }}</h4>
        <img src="{{ asset("storage/products/$pic->name_picture") }}">
        <p class="text-break">{{ $pic->name_picture }}</p>
        <a class="btn btn-danger mt-1" data-bs-toggle="modal" data-bs-target="#deletePictureModal-{{ $pic->id }}">
          <span><i class="fa-regular fa-trash-can me-1"></i></span>Delete
        </a>
      </div>

      @include('partials/modal', [
        'modal_id' => 'deletePictureModal-' . $pic->id,
        'modal_title' => 'Delete Product Picture #' . $loop->iteration - 1,
        'include_form' => 'true',
        'form_action' => '/admin/pictures/' . $pic->id ,
        'form_method' => 'post', 
        'additional_form_method' => 'delete', 
        'modal_body' => 'Are you sure want to delete <strong>' . $pic->name_picture . '</strong>?',
        'modal_footer' => '
        <button type="button" class="btn btn-secondary-native-regular" data-bs-dismiss="modal">Cancel Delete</button>
      <button type="submit" class="btn btn-danger"><span class="fa-regular fa-trash-can me-1"></span>Delete Picture</button>
        ',
      ])
    @endif
    @endforeach

  </div>

  <form action="/admin/pictures" method="post" enctype="multipart/form-data">
    @csrf
    <input type="hidden" value="{{ $product_data->id }}" name="product_id" required>
    <div class="form-group mb-3 mt-4">
      <label class="form-label"><h3>Add More Pictures (Max. 6 Additional Pictures)</h3></label>
      <div class="picture-input mt-2">
        <label class="form-label">New Picture #1</label>
        <input type="file" class="form-control first-pic" name="pictures[]" required>			
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
      <button type="submit" class="btn btn-primary-native"><span class="fa-solid fa-circle-check"></span> Add Pictures</button>
    </div>
  </form>
</div>
@endsection

@section('js_code')
<script>
$(document).ready(function () {
  let count = 1;
  let total_pic = {{ count($product_pictures_data) - 1 }};
  let remaining_pic = 6 - total_pic;

  if (remaining_pic === 0) {
    $(".picture-input").prepend(`<p class="text-danger">The maximum amount of pictures has been reached. Cannot add any pictures.</p>`);
    $(".first-pic").attr('disabled','disabled');
    $(".pic-submit").attr('disabled','disabled');
    $("#add-input").hide();
    $("#remove-input").hide();
  } else {
    $(".picture-input").prepend(`<p class="text-primary">Remaining pictures can be uploaded: ${remaining_pic}</p>`);
  
    if (count === 1 && remaining_pic === 1) {
      $("#remove-input").hide();
      $("#add-input").hide();
    }

    $(".add-input").on("click", function(){
      if (count <= remaining_pic) {
        $(".picture-input").append(`
        <div class="mt-3" id="picture-input-${count}">
          <label class="form-label">New Picture #${count + 1}</label>
          <input type="file" class="form-control" name="pictures[]">
        </div>
        `);
        count++;

        if (count === remaining_pic) {
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

        if (count === 1) {
          $("#remove-input").hide();
        } else {
          $("#add-input").show();
        }
      }
    });
  }
});
</script>
@endsection