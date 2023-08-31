@extends('layouts.main')

@section('container')
<section class="about_us container container-about">
  @if(session()->has('success'))
  <div class="home-alert">
    @include('partials/alert', [
      'status' => 'success',
      'message' => session('success'),
    ])
  </div>
  @endif
  <div class="row about_us-row mt-4">
    <div class="col-md-6 description-col">
      <h1>About Us</h1>
      <p>Dermanifest is a home-based bodycare business from Jakarta, Indonesia, since 2021.</p>
      <p>Dermanifest provides a variety of bodycare products such as facial Etawa goat milk masks & candlenut oil. Dermanifest also provides a complementary bodycare producs which also become a Customers' favorite, aromatherapy candles.</p>
      <p>Dermanifest was born from a curiosity from its owner about the wonders and creativity of bodycare products, where the products are depicted as a form of arts that can give wonder or heal people, inside or outside.</p>
      <p>Furthermore, Dermanifest aspries to utilize technology in delivering the best products and services to its Customers</p>
    </div>
    <div class="col-md-6 picture-col p-0">
      <img src="{{ asset('img/about_us/about_us_main.webp') }}" alt="">
    </div>
  </div>
  <div class="row">
    <div class="col-md-6 picture-col d-flex flex-row-reverse p-0">
      <img src="{{ asset('img/about_us/our_vision.webp') }}" alt="">
    </div>
    <div class="col-md-6 description-col">
      <h1>Our Vision</h1>
      <p>Through technology and creativity, Dermanifest is dedicated for creating sustainable and innovative bodycare solutions that can help individuals feel and look better. In addition, Dermanifest has a mission, namely:</p>
      <ol>
        <li>Committed to creating an environment where everyone has equal access to share their passion for beauty and a healthy and clean appearance.</li>          
        <li>Born and raised in a community that is motivated to make personal care products that are more accessible, applicable, and attractive.</li>
        <li>Understanding that each individual is unique in their own appearance and beauty so that the products provided also support and celebrate the uniqueness of each individual, helping them feel confident and comfortable with their appearance.</li>
      </ol>
    </div>
  </div>
  <div class="row about_us-row">
    <div class="col-md-6 description-col">
      <h1>All Natural</h1>
      <p>Dermanifest always ensures that all ingredients or materials used in production process are safe and natural. </p>
      <p>Dermanifest also prioritizes local ingredients first to help other local suppliers and businesses to grow together.</p>
    </div>
    <div class="col-md-6 picture-col p-0">
      <img src="{{ asset('img/about_us/all_natural.webp') }}" alt="">
    </div>
  </div>
</section>
@endsection