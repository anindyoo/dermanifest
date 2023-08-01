@extends('layouts.main')

@section('container')
<section class="product container container-product">

  <h1>All Product</h1>
  @foreach ($categories_data as $category)
  <div class="swiper productSwiper mb-4">
    <div class="row row-title-product">
      <div class="col-lg-12 col-md-12 col-sm-12">
        <div class="m-2">
          <div class="title">
            <h3>{{ $category->name_category }}</h3>
          </div>
          <div class="paragraph">
            <p>{{ $category->description_category }}</p>
          </div>
        </div>
      </div>
    </div>

    <div class="row row-product swiper-wrapper mb-5" id="scrollhere">
      @foreach ($products_data as $product)
      @if ($category->id == $product->category_id)
      <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 swiper-slide">
        <a href="/products/{{ $product->id }}">
          <div class="card swiper-slide">
            <div class="image-product">
              <div class="hover-desc">
                <p><i class="fa fa-search" aria-hidden="true"></i></p>
              </div>
              <img src="{{ asset("storage/products/$product->main_picture") }}" alt="...">
            </div>
            <div class="product-content">
              <div class="text-content">
                <h5 class="fw-bold">{{ $product->name_product }}</h5>
                <p class="m-0">{{ $category->name_category }}</p>
                <p class="m-0">{{ $product->net_weight }} gr</p>
              </div>
              <div class="product-price d-flex flex-column justify-content-end align-items-end mb-2">
                @if ($product->discount_price)
                  <h5 class="fw-bold">Rp{{ number_format($product->discount_price, 0, ',', '.') }},-</h5>
                  <del>Rp{{ number_format($product->price, 0, ', ', '.') }},-</del>                    
                @else
                  <h5 class="fw-bold">Rp{{ number_format($product->price, 0, ', ', '.') }},-</h5>                    
                @endif
              </div>
              <a href="" class="btn btn-buy btn-cart">
                <box-icon type='solid' name='cart-add'><i class='bx bxs-cart-add' style="width: 20px; height: auto;"></i></box-icon> Add to Cart 
              </a>
            </div>
          </div>
        </a>
      </div>
      @endif        
      @endforeach
    </div> 
    
    <div class="row me-2">
      <div class="mt-4 col-xl-12 col-lg-12 col-md-12 col-sm-12 d-flex col-button flex-row-reverse">
        <p class="button-next">NEXT</p>
        <p class="button-prev me-3">PREV</p>
      </div>
    </div>
  </div>
  @endforeach
</section>
@endsection

@section('js_code')
<script>
// Product List Swiper
var swiper = new Swiper(".productSwiper", {
  grabCursor: true,
  slidesPerView: 4,
  slidesPerColumn: 0,
  spaceBetween: 10,
  loop: true,
  breakpoints: {
    1200: {
      slidesPerView: {{ count($products_data) }} < 4 ? {{ count($products_data) }} : 4,
      spaceBetween: 0
    },

    768: {
      slidesPerView: 3,
      spaceBetween: 0
    },
    412: {
      slidesPerView: 2,
      spaceBetween: 0
    },
    240: {
      slidesPerView: 1,
      spaceBetween: 0
    },
    
  },
  pagination: {
    el: ".swiper-pagination",
    clickable: true,
  },
  navigation: {
    nextEl: ".button-next",
    prevEl: ".button-prev",
  },
});
</script>
@endsection