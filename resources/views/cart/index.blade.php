@extends('layouts.main')

@section('container')
<section class="cart container container-cart">
  @if(session()->has('success'))
  <div class="home-alert">
    @include('partials/alert', [
      'status' => 'success',
      'message' => session('success'),
    ])
  </div>
  @elseif(session()->has('danger'))
  <div class="home-alert">
    @include('partials/alert', [
      'status' => 'danger',
      'message' => session('danger'),
    ])
  </div>
  @endif
  @if (session()->has('cart'))
  @foreach ($errors->all() as $error)
    <div class="home-alert">
      @include('partials/alert', [
        'status' => 'danger',
        'message' => $error,
      ])
    </div>
  @endforeach
  <div class="row mt-4 mb-5">
    <h1 class="mb-3">Cart</h1>
    <div class="col-md-9">
      <div class="table-responsive">
        <table class="table table-responsive table-cartorder table-responsive p-3">
          <thead>
            <tr>
              <th class="text-center"><h5>Product</h5></th>
              <th><h5>Quantity</h5></th>
              <th><h5>Amount</h5></th>
            </tr>
          </thead>
          <tbody>
            @foreach ($products_data as $key => $product)      
            @if ($product->stock > 0)
            <tr class="cart-items">
              <td class="td-product">   
                <div class="d-flex">
                  <a href="/products/{{ $product->slug }}"><img src="{{ asset('storage/products/' . $product->main_picture) }}" alt="" style="object-fit: contain;"></a>
                  <div class="d-flex flex-column ms-4">
                    <div class="data-text">
                      <a href="/products/{{ $product->slug }}" class="to-product"><h5 class="mb-1">{{ $product->name_product }}</h5></a>
                      <p>{{ $product->category_name }}</p>
                      @if ($product->discount_price)
                        <h5 class="fw-bold">Rp{{ number_format($product->discount_price, 0, ',', '.') }},-</h5>
                        <del><p>Rp{{ number_format($product->price, 0, ', ', '.') }},-</p></del>                    
                      @else
                        <h5 class="fw-bold">Rp{{ number_format($product->price, 0, ', ', '.') }},-</h5>                    
                      @endif
                    </div>
                    <form action="/cart/{{ $product->id }}" method="post">
                      @csrf
                      @method('delete')
                      <input type="hidden" name="id" value="{{ $product->id }}">
                      <button type="submit" class="link-danger btn btn-link p-0">
                        <i class="fa-regular fa-trash-can me-1"></i> Remove
                      </button>
                    </form>
                  </div>
                </div>                                 
              </td>
                <td class="td-quantity">
                  <form action="/cart/{{ $product->id }}" method="post">
                    @method('put')
                    @csrf
                    <div class="d-flex flex-column">
                      <input type="hidden" value="{{ $product->id }}" name="id">
                      <input type="number" class="form-control" id="quant" name="item_quantity" min="1" max="{{ $product->stock }}" value="{{ $cart_items[$key]['quantity'] }}" style="height:35px;"> 
                      <button type="submit" class="btn btn-primary-native-regular mt-2"><i class="fa-solid fa-pen-to-square"></i> Update</button>                  
                    </div>
                  </form>
                </td>
                <td>
                  @if ($product->discount_price)
                    <h5 class="fw-bold">Rp{{ number_format($product->discount_price * $cart_items[$key]['quantity'], 0, ',', '.') }},-</h5>
                  @else
                    <h5 class="fw-bold">Rp{{ number_format($product->price * $cart_items[$key]['quantity'], 0, ', ', '.') }},-</h5>                    
                  @endif
                </td>
            </tr>
            @endif
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
    <div class="col-md-3">
      <h3>Summary</h3>
      <h5 class="fw-bold">Quantity</h5>
      <p>{{ session()->get('cart')['quantity_total'] }} pcs</p>
      <h5 class="fw-bold">Subtotal</h5>
      <h3 class="fw-bold">Rp{{ number_format((session()->get('cart')['subtotal']), 0, ', ', '.') }},-</h3>
      <div class="d-flex flex-column mt-5">
        <a href="/order/create" class="btn btn-primary-native">Checkout</a>
      </div>
      <form action="/cart/destroyAll" method="post">
        @csrf
        <button type="submit" class="btn btn-outline-danger mt-3">Delete</button>
      </form>
    </div>
  </div>
  @else
    <div class="empty-cart rounded-3 mt-5">
      <h2>Your cart is still empty. Let's shop something!</h2>
      <a href="/products" class="btn btn-primary-native mt-4">Shop Products</a>
    </div>      
  @endif
</section>
@endsection