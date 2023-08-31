@extends('layouts.main')

@section('container')
<!-- HERO -->
<section class="hero">
  <div class="container hero-container">
    <div class="row hero-row">
      <div class="col-lg-12 col-md-12 col-sm-12">
        <div class="hero-col">
          <div class="text-hero">
            @auth
              <h2>Hello, {{ Auth::user()->name_customer }}!</h2>
              <p>
                Let's take a litte journey</br>
                at Dermanifest today!
              </p>
            @endauth
            @guest
              <h2>
                Welcome to</br>Dermanifest!
              </h2>
              <p>
                Take a litte journey here and</br>
                let's manifest your inner-out tranquilty!
              </p>
              <br>
              <div>        
                <a href="/login" class="btn btn-primary-native">Log In</a>
                <a href="/register" class="btn btn-secondary-native secondary-color-light">Register</a>              
              </div>
            @endguest
          </div>
          @if(session()->has('success'))
            <div class="home-alert">
              @include('partials/alert', [
                'status' => 'success',
                'message' => session('success'),
              ])
            </div>
          @endif
          <div id="carouselExampleIndicators" class="image-hero carousel slide" data-bs-ride="carousel" data-bs-touch="true">
            <div class="carousel-indicators">
              <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
              <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1" aria-label="Slide 2"></button>
              <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2" aria-label="Slide 3"></button>
              <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="3" aria-label="Slide 4"></button>
              <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="4" aria-label="Slide 5"></button>
              <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="5" aria-label="Slide 6"></button>
            </div>
            <div class="carousel-inner">
              <div class="carousel-item active">
                <img src="{{ asset('img/hero-1.webp') }}" class="d-block w-100" alt="Visit Dermanifest on Shopee">
              </div>
              <div class="carousel-item">
                <img src="{{ asset('img/hero-2.webp') }}" class="d-block w-100" alt="Dermanifest Aromatherapy Candles New Edition">
              </div>
              <div class="carousel-item">
                <img src="{{ asset('img/hero-3.webp') }}" class="d-block w-100" alt="Dermanifest Organic Beauty Mask">
              </div>
              <div class="carousel-item">
                <img src="{{ asset('img/hero-4.webp') }}" class="d-block w-100" alt="Dermanifest Etawa Goat Milk Mask">
              </div>
              <div class="carousel-item">
                <img src="{{ asset('img/hero-5.webp') }}" class="d-block w-100" alt="Dermanifest Scented Candle Classic Edtion">
              </div>
              <div class="carousel-item">
                <img src="{{ asset('img/hero-6.webp') }}" class="d-block w-100" alt="Dermanifest Candlenut Oil">
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
        </div>
      </div>
    </div>
  </div>
</section>

<!-- SPACER -->
<section class="spacer">
  <div class="container spacer-container">
    <div class="row spacer-row">
      <div class="col-lg-2 col-md-2 col-sm-4 col-4 col-item mb-3 p-5">              
      </div>
    </div>
  </div>
</section>

<!-- ABOUT -->
<section class="about" id="scroll-about">
  <div class="container about-container">
    <div class="row about-row">
      <div class="col-lg-8 col-md-6 col-sm-12">
        <div class="title mb-3">
          <h1>About Us</h1>
        </div>
        <div class="paragpraph mb-5">
          <p>Dermanifest is a home-based bodycare business from Jakarta, Indonesia, since 2021.</p>
          <p>Dermanifest provides a variety of bodycare products such as facial Etawa goat milk masks & candlenut oil. Dermanifest also provides a complementary bodycare producs which also become a Customers' favorite, aromatherapy candles.</p>
        </div>
        <div class="subtitle mb-3">
          <a href="/about_us" class="btn btn-primary-native">Read More About Us</a>
        </div>
      </div>
      <div class="col-lg-4 col-md-6 col-sm-12">
        <div class="image-about">
          <img src="{{ asset('img/about-pics.webp') }}" alt="About us collage">
        </div>
      </div>
    </div>
  </div>
</section>

<!-- PRODUCT -->
<section class="product">
  <div class="container container-product swiper productSwiper">
    <div class="row row-title-product mb-5">
      <div class="col-lg-12 col-md-12 col-sm-12">
        <div class="product-content">
          <div class="title">
            <h1>Top Product</h1>
          </div>
          <div class="paragraph">
            <p>Our top product, truthfully crafted for you.</p>
          </div>
        </div>
      </div>
    </div>
    <div class="row row-product swiper-wrapper mb-5" id="scrollhere">
    @foreach ($products_data as $product)
      <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 swiper-slide">
        <div class="card swiper-slide">
            <a href="/products/{{ $product->slug }}">
            <div class="image-product">
              <div class="hover-desc">
                <p><i class="fa fa-search" aria-hidden="true"></i></p>
              </div>
              <img src="{{ asset("storage/products/$product->main_picture") }}" alt="...">
            </div>
            <div class="product-content">
              <div class="text-content">
                <h5 class="fw-bold">{{ $product->name_product }}</h5>
                <p class="m-0">{{ $product->category_name }}</p>
                <p class="m-0">{{ $product->net_weight }} gr</p>
              </div>
            </a>
            <div class="product-price d-flex flex-column justify-content-end align-items-end mb-2">
              @if ($product->discount_price)
                <h5 class="fw-bold m-0">Rp{{ number_format($product->discount_price, 0, ',', '.') }},-</h5>
                <del>Rp{{ number_format($product->price, 0, ', ', '.') }},-</del>                    
              @else
                <h5 class="fw-bold m-0">Rp{{ number_format($product->price, 0, ', ', '.') }},-</h5>                    
              @endif
            </div>
            <form action="/cart" method="post">
              @if ($product->stock == 0)
              <p class="m-0 text-danger">Out of stock!</p>
              @endif
              <button type="submit" class="btn btn-buy btn-cart" @if ($product->stock == 0) disabled @endif>
              @csrf
                <input type="hidden" name="id" value="{{ $product->id }}">
                <box-icon type='solid' name='cart-add'><i class='bx bxs-cart-add' style="width: 20px; height: auto;"></i></box-icon> Add to Cart 
              </button>
            </form>
          </div>
        </div>
      </div>
    @endforeach
    </div> 
    <div class="row me-2">
      <div class="mt-4 col-xl-12 col-lg-12 col-md-12 col-sm-12 d-flex col-button flex-row-reverse">
        <p class="button-next">NEXT</p>
        <p class="button-prev me-3">PREV</p>
      </div>
    </div>
  </div>
</section> 

<!-- BUY -->
<section>
  <div class="container buy-container">
    <div class="row buy-row">
      <div class="col-lg-6 col-md-6 col-sm-12 col-12 col-buy">
        <div class="title mb-3">
          <h1>Buy Here</h1>
        </div>
        <div class="paragraph mb-5">
          <p>You can purchase our products comfortably and 
              safely through the following media or
              <span class="link-contact">
                <a href="#" target="_blank">Whatsapp us for fast service</a>
              </span>
            </p>
        </div>
        <div class="button-buy">
          <a href="/products" class="btn btn-buy">Shop Now</a>
        </div>
      </div>
      <div class="col-lg-6 col-md-6 col-sm-12 col-12 col-img">
        <img src="{{ asset('img/buy-pic.webp') }}" alt="Dermanifest Organic Beauty Mask">
      </div>
    </div>

    <div class="row eshop-row">
      <div class="col-lg-12 col-md-12 col-sm-12 col-12 col-eshop">
        <div class="image-item">
            <a href="https://shopee.co.id/dermanifest">
              <img src="{{ asset('img/shopee.webp') }}" alt="Shopee Logo">
            </a>
        </div>
        <div class="image-item">
            <a href="https://www.instagram.com/dermanifest/">
              <img src="{{ asset('img/instagram.webp') }}" alt="Instagram Logo">
            </a>
        </div>
      </div>
    </div>
  </div>
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