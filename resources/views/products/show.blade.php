@extends('layouts.main')

@section('container')
<section class="product-detail container mb-5">
  @if(session()->has('success'))
    <div class="home-alert">
      @include('partials/alert', [
        'status' => 'success',
        'message' => session('success'),
      ])
    </div>
  @endif
  <div class="row mt-3">
    <div class="pictures d-flex justify-content-center flex-column col-md-5">
      <div style="--swiper-navigation-color: #fff; --swiper-pagination-color: #fff" class="swiper mySwiper2">
        <div class="swiper-wrapper">
          @foreach ($pictures_data as $pic)
          @if ($pic->name_picture != $product_data->main_picture)
          <div class="swiper-slide">
            <img src="{{ asset("storage/products/$pic->name_picture") }}" />
          </div>              
          @endif
          @endforeach
        </div>
        <div class="swiper-button-next"></div>
        <div class="swiper-button-prev"></div>
      </div>
      <div thumbsSlider="" class="swiper mySwiper thumbs">
        <div class="swiper-wrapper">
          <div class="swiper-slide">
            <img src="{{ asset("storage/products/$product_data->main_picture") }}" />
          </div>
          @foreach ($pictures_data as $pic)
          @if ($pic->name_picture != $product_data->main_picture)
          <div class="swiper-slide">
            <img src="{{ asset("storage/products/$pic->name_picture") }}" />
          </div>              
          @endif
          @endforeach
        </div>
      </div>
    </div>
    <div class="details col-md-7">
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="/"><u>Home</a></u></li>
          <li class="breadcrumb-item"><a href="/products"><u>Product List</a></u></li>
          <li class="breadcrumb-item active" aria-current="page">{{ $product_data->name_product }}</li>
        </ol>
      </nav>
      <h2>{{ $product_data->name_product }}</h2>
      <div class="description-detail mt-3">
        <h4>Description</h4>
        <div>{!! $product_data->description !!}</div>
      </div>
      <div class="instruction-detail mt-3">
        <h4>How to Use</h4>
        <div>{!! $product_data->instruction !!}</div>
      </div>
      <div class="ingredients-detail mt-3">
        <h4>Ingredients</h4>
        <div>{!! $product_data->ingredients !!}</div>
      </div>
      <div class="stock-detail mt-3">
        <h4>Stock</h4>
        <div>{{  $product_data->stock  }} pc(s)</div>
      </div>
      <div class="neto-price d-flex justify-content-between">
        <div class="neto-detail mt-3">
          <h4>Net Weight</h4>
          <p>{{ $product_data->net_weight }} gram</p>
        </div>
        <div class="price-detail mt-3">
          <h4>Price</h4>
          @if ($product_data->discount_price)
            <h3 class="fw-bold">Rp{{ number_format($product_data->discount_price, 0, ',', '.') }},-</h3>
            <h5 style="color: #656565;"><del>Rp{{ number_format($product_data->price, 0, ', ', '.') }},-</del></h5>
          @else
            <h3 class="fw-bold">Rp{{ number_format($product_data->price, 0, ', ', '.') }},-</h3>                    
          @endif
        </div>    
      </div>
      <div class="mt-4">
        <form action="/cart" method="post">
          @csrf
          <input type="hidden" name="id" value="{{ $product_data->id }}">
          @if ($product_data->stock == 0)
          <p class="text-danger">Out of stock!</p>
          @endif
          <button type="submit" class="btn btn-buy btn-primary-native w-100" @if ($product_data->stock == 0) disabled @endif>
            <box-icon type='solid' name='cart-add'><i class='bx bxs-cart-add' style="width: 20px; height: auto;"></i></box-icon> Add to Cart 
          </button>
        </form>
      </div>
    </div>
  </div>
</section>
@endsection

@section('js_code')
<script>
  var swiper = new Swiper(".mySwiper", {
    loop: false,
    spaceBetween: 10,
    slidesPerView: 4,
    freeMode: true,
    watchSlidesProgress: true,
  });
  var swiper2 = new Swiper(".mySwiper2", {
    loop: false,
    spaceBetween: 10,
    navigation: {
      nextEl: ".swiper-button-next",
      prevEl: ".swiper-button-prev",
    },
    thumbs: {
      swiper: swiper,
    },
  });
</script>
@endsection