@extends('layouts.main')

@section('container')
<section class="product-detail container mb-5">
  @if(session()->has('success'))
    <div class="home-alert">
      <div class="alert alert-success" role="alert">
        {{ session('success') }}
      </div>
    </div>
  @endif
  <div class="row mt-3">
    <div class="pictures d-flex justify-content-center flex-column col-md-5">
      @if (1+2 ==232)
      <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="true">
        <div class="carousel-indicators">
          <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
          <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="##########NEXT#########" aria-label="#######################"></button>
        </div>
        <div class="carousel-inner">         
          <div class="carousel-item active">
            <img src="{{ asset("storage/products/$product_data->main_picture") }}" class="d-block w-100" alt="...">
          </div>
          <div class="carousel-item">
            <img src="https://placehold.co/400x600" class="d-block w-100" alt="...">
          </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
          <span class="carousel-control-prev-icon" aria-hidden="true"></span>
          <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
          <span class="carousel-control-next-icon" aria-hidden="true"></span>
          <span class="visually-hidden">Next</span>
        </button>  
      </div>
      @endif
      <div style="--swiper-navigation-color: #fff; --swiper-pagination-color: #fff" class="swiper mySwiper2">
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
      <div class="d-flex mt-4">
        <a href="" class="btn btn-buy w-100"><i class="fas fa-cart-plus"></i>  Add to Cart</a>
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