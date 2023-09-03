@extends('layouts.main')

@section('csrf_token')
<meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('container')
<section class="order-checkout cart container">
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
  @foreach ($errors->all() as $error)
  <div class="home-alert">
    @include('partials/alert', [
      'status' => 'danger',
      'message' => $error,
    ])
  </div>
  @endforeach
  <form action="/order" method="post">
  <h1 class="mb-3">Order Checkout</h1>
  <div class="row mt-4 mb-5">
    @csrf
    <div class="col-md-7">
      <div class="table-responsive">
        <table class="table table-cartorder table-responsive p-3">
          <thead>
            <tr>
              <th class="text-center" style="width=74%"><h5>Product</h5></th>
              <th style="width=6%"><h5>Quantity</h5></th>
              <th style="width=20%"><h5>Amount</h5></th>
            </tr>
          </thead>
          <tbody>
            @foreach ($products_data as $key => $product)
            <input type="hidden" name="product_id[]" value="{{ $product->id }}" required>                
            <input type="hidden" name="product_slug[]" value="{{ $product->slug }}" required>                
            <tr class="cart-items">
              <td class="td-product">   
                <div class="d-flex">
                  <a href="/products/{{ $product->slug }}"><img src="{{ asset('storage/products/' . $product->main_picture) }}" alt="" style="object-fit: contain;"></a>
                  <input type="hidden" name="main_picture[]" value="{{ $product->main_picture }}" required>                
                  <div class="d-flex flex-column ms-4">
                    <div class="data-text">
                      <a href="/products/{{ $product->slug }}" class="to-product">
                        <h5 class="mb-1">{{ $product->name_product }}</h5>
                        <input type="hidden" name="product_name[]" value="{{ $product->name_product }}" required>                
                      </a>
                      <p>{{ $product->category_name }}</p>
                      <input type="hidden" name="category_name[]" value="{{ $product->category_name }}" required>                
                      @if ($product->discount_price)
                      <h5 class="fw-bold">Rp{{ number_format($product->discount_price, 0, ',', '.') }},-</h5>
                      <del><p>Rp{{ number_format($product->price, 0, ', ', '.') }},-</p></del>                    
                      @else
                      <h5 class="fw-bold">Rp{{ number_format($product->price, 0, ', ', '.') }},-</h5>                    
                      @endif
                      <input type="hidden" name="price[]" value="{{ $product->price }}" required>                
                      <input type="hidden" name="discount_price[]" value="{{ $product->discount_price }}" required>                
                    </div>
                  </div>
                </div>                                 
              </td>
              <td class="td-quantity">
                <span class="d-flex align-items-baseline">
                  <h5>{{ $cart_items[$key]['quantity'] }}</h5>
                  <h6 class="ms-1">pcs</h6>
                  <input type="hidden" name="quantity[]" value="{{ $cart_items[$key]['quantity'] }}" required>                
                  </span>
                </td>
                <td>
                  @if ($product->discount_price)
                    <h5 class="fw-bold">Rp{{ number_format($product->discount_price * $cart_items[$key]['quantity'], 0, ',', '.') }},-</h5>
                    <input type="hidden" name="price_total[]" value="{{ $product->discount_price * $cart_items[$key]['quantity'] }}" required>                
                    @else
                    <h5 class="fw-bold">Rp{{ number_format($product->price * $cart_items[$key]['quantity'], 0, ', ', '.') }},-</h5>                    
                    <input type="hidden" name="price_total[]" value="{{ $product->price * $cart_items[$key]['quantity'] }}" required>                
                  @endif
                </td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
      <div class="checkout-summary mt-3">
        <h3 class="mb-3">Summary</h3>
        <hr>
        <div class="d-flex justify-content-between mb-1">
          <h5 class="poppins-font fw-normal">Delivery Courier</h5>            
          <h5 id="delivery_courier-detail">-</h5>
          <input id="delivery_courier-input" type="hidden" class="form-control" name="delivery_courier" required>
        </div>
        <div class="d-flex justify-content-between mb-1">
          <h5 class="poppins-font fw-normal">Delivery Service</h5>            
          <h5 id="delivery_service-detail">-</h5>
          <input id="delivery_service-input" type="hidden" class="form-control" name="delivery_service" required>
        </div>
        <div class="d-flex justify-content-between mb-1">
          <h5 class="poppins-font fw-normal">Delivery Cost</h5>            
          <h5 id="delivery_cost-detail">-</h5>
          <input id="delivery_cost-input" type="hidden" class="form-control" name="delivery_cost" required>
        </div>
        <hr>
        <div class="d-flex justify-content-between mb-1">
          <h5 class="poppins-font fw-normal">Quantity Total</h5>
          <h5>{{ session()->get('cart')['quantity_total'] }} pcs</h5>
          <input id="quantity_total-input" type="hidden" name="quantity_total" value="{{ session()->get('cart')['quantity_total'] }}" required>       
        </div>
        <div class="d-flex justify-content-between mb-1">
          <h5 class="poppins-font fw-normal">Gross Weight Total</h5>
          <h5>{{ session()->get('cart')['gross_weight_total'] }} gr</h5>
          <input id="gross_weight_total-input" type="hidden" name="gross_weight_total" value="{{ session()->get('cart')['gross_weight_total'] }}" required>
        </div>
        <div class="d-flex justify-content-between mb-1">
          <h5 class="poppins-font fw-normal">Subtotal</h5>
          <h5>Rp{{ number_format((session()->get('cart')['subtotal']), 0, ', ', '.') }},-</h5>
          <input id="subtotal-input" type="hidden" name="subtotal" value="{{ (session()->get('cart')['subtotal']) }}" required>       
        </div>
        <div class="d-flex justify-content-between mb-1">
          <h5 class="poppins-font fw-normal">Delivery Cost</h5>
          <h5 id="delivery_cost-summary">Rp0,-</h5>
        </div>
        <hr>
        <div class="d-flex justify-content-between">
          <h5 class="fw-bold">Grand Total</h5>
          <h3 id="grand_total-summary" class="fw-bold">Rp{{ number_format((session()->get('cart')['subtotal']), 0, ', ', '.') }},-</h3>
          <input id="grand_total-input" type="hidden" name="grand_total" required>       
        </div>
      </div>        
    </div>
    <div class="col-md-5">
      <div class="order-detail accdetail">
        <h5>Order Detail</h5>
        <div class="d-flex justify-content-between checkout-data">
          <p class="text-primary-native m-0">Date</p>            
          <p class="m-0">{{ $date }}</p>
        </div>
      </div>
      <div class="recepient-detail accdetail">
        <h5>Recepient</h5>
        <div class="checkout-data">
          <div class="form-group mb-2">
            <label class="form-label">Name</label>
            <input id="name" type="text" class="form-control" name="recipient" value="{{ Auth::user()->name_customer }}" required>
            <input id="customer_id" type="hidden" class="form-control" name="customer_id" value="{{ Auth::user()->id }}" required>
          </div>
          <div class="form-group mb-2">
            <label class="form-label">Email</label>
            <input id="email" type="email" class="form-control" name="email" value="{{ Auth::user()->email }}" required>
          </div>
          <div class="form-group mb-2">
            <label class="form-label">Phone</label>
            <input id="phone" type="tel" class="form-control" name="phone" value="{{ Auth::user()->phone }}" required>
          </div>
        </div>
      </div>
      <div class="delivery-detail accdetail">
        <h5>Delivery</h5>
        <div class="address-row d-flex flex-column mt-3 mb-3">
          @if (count($addresses_data) > 0)
            <label class="radio-card-container card-input">
              <input type="radio" class="card-input-element" name="address_id" value="0"/>
              <div class="card card-input-selected address-card mb-3">
                <div class="card-body d-flex justify-content-between flex-column">
                  <div>
                    <div class="d-flex justify-content-between">
                      <h5 class="card-title">Use New Address</h5>
                      <div class="radio-card-check">
                        <i class="fa-regular fa-circle"></i>
                        <i class="fa-solid fa-check-circle"></i>
                      </div>
                    </div>                                
                  </div>
                </div>
              </div>
            </label>                                    
            @foreach ($addresses_data as $addy)
            <label class="radio-card-container card-input">
              <input type="radio" name="address_id" class="card-input-element" value="{{ $addy->id }}"/>
              <div class="card address-card mb-3">
                <div class="card-body d-flex justify-content-between flex-column">
                  <div>
                    <div class="d-flex justify-content-between">
                      <h5 class="card-title">{{ $addy->name_address }}</h5>
                      <div class="radio-card-check">
                        <i class="fa-regular fa-circle"></i>
                        <i class="fa-solid fa-check-circle"></i>
                      </div>
                    </div>
                    <p class="card-text">{{ $addy->address }}</p>            
                    <p class="card-text">{{ $addy->province }}, {{ $addy->city }}</p>                                    
                  </div>
                </div>
              </div>
            </label>                                    
            @endforeach                    
          @endif
        </div>
        <div class="checkout-data">
          <div class="mb-2 address-input form-group">
            <label for="address-input" class="form-label">Address Title</label>            
            <input type="text" id="address_name-input" class="form-control" name="name_address" placeholder="e.g.: My House, New Office, Mom\'s House etc." required>
          </div>
          <div class="form-group mb-2">
            <label class="form-label">Address</label>
            <textarea class="form-control" name="address" id="address-input" rows="3" required></textarea>
          </div>
          <div class="form-group mb-2">
            <label class="form-label">Province</label>
            <input id="province_id-input" type="hidden" name="province_api_id" required>         
            <input id="province_name-input" type="hidden" name="province" required>
            <span id="province-loader">
              <div class="lds-ring"><div></div><div></div><div></div><div></div></div>
              <p class="d-inline">Loading Province...</p>
            </span>
            <select id="province-select" class="form-select" aria-label="Select Province" name="province" required>
              <option hidden disabled selected value="">Select Province</option>
              {!! $provinces !!}
            </select>
          </div>
          <div class="form-group mb-2">
            <label class="form-label">City/District</label>
            <input id="city_id-input" type="hidden" name="city_api_id" required>                 
            <input id="city_name-input" type="hidden" name="city" required>
            <span id="city-loader">
              <div class="lds-ring"><div></div><div></div><div></div><div></div></div>
              <p class="d-inline">Loading City...</p>
            </span>
            <select id="city-select" class="form-select" aria-label="Select City" required>
              <option hidden disabled selected value>Select City/District</option>              
            </select>
          </div>
          <div class="form-group mb-2">
            <label class="form-label">Delivery Service</label>
            <span id="service-loader">
              <div class="lds-ring"><div></div><div></div><div></div><div></div></div>
              <p class="d-inline">Loading Service...</p>
            </span>
            <select id="service-select" class="form-select" aria-label="Select Delivery Service" required>
              <option hidden disabled selected value>Select delivery service</option>                
            </select>
          </div>
          <div class="form-group mb-2">
            <label class="form-label">Postal Code</label>
            <input id="postal_code-input" type="num" class="form-control" name="postal_code" required>
          </div>
          <div class="form-group mb-2">
            <label class="form-label">Note (optional)</label>
            <textarea class="form-control" name="note" id="addres-input" rows="3"></textarea>
          </div>            
        </div>
        <div class="checkout-buttons d-flex flex-column">
          <button type="submit" class="btn btn-primary-native mb-2">Make Order</button>
          <a href="/cart" class="btn btn-secondary-native">Back</a>
        </div>       
      </div>      
    </div>
  </div>
  <div class="checkout-buttons-mobile d-flex flex-column d-none">
    <button type="submit" class="btn btn-primary-native mb-2">Make Order</button>
    <a href="/cart" class="btn btn-secondary-native">Back</a>
  </div> 
  </form>
</section>
@endsection
@section('js_code')
<script>
// Rajaongkir Dependent Select Option
$(document).ready(function() {
  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });
  
  $('#city-select').select2();
  var costAjax = [];
  
  function getCostByCity() {
    var selectedCityId = $("option:selected", this).attr("city_id");
    var selectedCityName = $("option:selected", this).val();
    $('#city_name-input').val(selectedCityName);
    $('#city_id-input').val(selectedCityId);

    var data = {
      destination: selectedCityId,
      weight: {{ session()->get('cart')['gross_weight_total'] }},
    };
    $('#service-loader').show();
    var getCostAjax = $.ajax({
      type: 'post',
      url: '/get_delivery_cost',
      data: {option:data},
      beforeSend: function () {
        $('#service-select').prop('disabled', true);
      },
      complete: function () {
        $('#service-select').removeAttr('disabled');
        $('#province-loader').hide();
        $('#city-loader').hide();
        $('#service-loader').hide();
      },
    }).done(function(cost_list) {           
      $('#service-select').find('optgroup').remove().end()        

      for (const [key, services] of Object.entries(cost_list)) {
        var courier = key;
                
        $('#service-select').append(
          $("<optgroup></optgroup>")
            .attr("label", courier.toUpperCase())              
            .attr("id", courier + '-group')              
        ); 

        $.each(services, function(key, service) {   
          $('#' + courier + '-group').append(
            $("<option></option>")
              .attr("delivery_courier", courier.toUpperCase())              
              .attr("delivery_service", service.service)              
              .attr("delivery_cost", service.cost[0].value)              
              .text(service.service + '—' + service.description + ' (' + service.cost[0].etd + ' / days) Rp' +  service.cost[0].value + ',-')
          ); 
        });
      }
    });
    costAjax.push(getCostAjax);
  }

  function resetValue() {
    var subtotal = {{ session()->get('cart')['subtotal'] }};
    $('#delivery_courier-input').val('');
    $('#delivery_service-input').val('');
    $('#delivery_cost-input').val('');
    $('#grand_total-input').val('');

    $('#delivery_courier-detail').text('-');
    $('#delivery_service-detail').text('-');
    $('#delivery_cost-detail').text('Rp0,-');
    $('#delivery_cost-summary').text('Rp0,-');
    $('#grand_total-summary').text('Rp' + subtotal.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1.') + ',-');
  }
  $('#province-loader').hide();

  $('#city-select').prop('disabled', true);
  $('#city-loader').hide();

  $('#province-select').on("change", function() {
    var selectedProvinceId = $("option:selected", this).attr("province_id");
    var selectedProvinceName = $("option:selected", this).val();
    $('#province_name-input').val(selectedProvinceName);
    $('#province_id-input').val(selectedProvinceId);
    $('#city-loader').show();
    $.ajax({
      type: 'post',
      url: '/citiesByProvinceId/' + selectedProvinceId,
      data: {},
      beforeSend: function() {
        $('#city-select').prop('disabled', true);
        $('#service-select').prop('disabled', true);
      },
      complete: function() {
        $('#city-select').removeAttr('disabled');
        $('#city-loader').hide();
      },
    }).done(function(cities) {           
      $('#city-select').find('option').remove().end()
        .append('<option hidden disabled selected value>Select City/District</option>');
      $('#service-select').find('option').remove().end()
        .append('<option hidden disabled selected value>Select Delivery Service</option>');
      $.each(cities, function(key, city) {   
        $('#city-select').append(
          $("<option></option>")
            .attr("value", city['type'] + ' ' + city['city_name'])
            .attr("id", city['city_id'])
            .attr("city_id", city['city_id'])
            .attr("postal_code", city['postal_code'])
            .text(city['type'] + ' ' + city['city_name'])
        ); 
      });
    });
  });
  $('#province-select').on("change", resetValue);
  
  $('#service-select').prop('disabled', true);
  $('#service-loader').hide();

  $('#city-select').on("change", getCostByCity);
  $('#city-select').on("change", resetValue);

  $('#service-select').on("change", function() {
    var selectedCourier = $("option:selected", this).attr("delivery_courier");
    var selectedService = $("option:selected", this).attr("delivery_service");
    var selectedCost = $("option:selected", this).attr("delivery_cost");
    var subtotal = {{ session()->get('cart')['subtotal'] }};
    var grandTotal = parseInt(selectedCost) + subtotal; 

    $('#delivery_courier-input').val(selectedCourier);
    $('#delivery_service-input').val(selectedService);
    $('#delivery_cost-input').val(selectedCost);
    $('#grand_total-input').val(grandTotal);

    $('#delivery_courier-detail').text(selectedCourier);
    $('#delivery_service-detail').text(selectedService);
    $('#delivery_cost-detail').text('Rp' + selectedCost.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1.') + ',-');
    $('#delivery_cost-summary').text('Rp' + selectedCost.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1.') + ',-');
    $('#grand_total-summary').text('Rp' + grandTotal.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1.') + ',-');
  });

  

  $('.card-input').find('.fa-check-circle').hide();
  $('.card-input').find('.fa-circle').show();
  $('.card-input-selected').find('.fa-check-circle').show();
  $('.card-input-selected').find('.fa-circle').hide();

  $('.card-input').click(function() {
    if (costAjax.length != 0) {
      $('#province-loader').show();
      $('#city-loader').show();
      $('#service-loader').show();
      $('#service-select').prop('disabled', true);
      for (var i = 0; i < costAjax.length; i -=- 1) {
        costAjax[i].abort();
      }
    }          
    var selectedCard = $(this).find('.card-input-element').val();
    $('.card-input').find('.fa-check-circle').hide();
    $('.card-input').find('.fa-circle').show();
    $('.card-input').find('.card').removeClass('card-input-selected');
    $(this).find('.card').addClass('card-input-selected');
    $(this).find('.fa-circle').hide();
    $(this).find('.fa-check-circle').show();
    if (selectedCard > 0) {
      $.ajax({
        type: 'post',
        url: '/get_address',
        data: {option: selectedCard},
      }).done(function(address) {           
        $('#address_name-input').val(address.name_address);
        $('#address-input').val(address.address);
        $('#province_name-input').val(address.province);
        $('#province-select').append(
          $("<option></option>")
            .attr('value', address.province)
            .attr('id', address.province_api_id)
            .attr('province_id', address.province_api_id)
            .attr('postal_code', address.postal_code)
            .prop('selected', true)
            .text(address.province)
        ).prop('disabled', true); 
        $('#city_name-input').val(address.city);
        $('#city-select').select2({disabled:'readonly'});
        $('#city-select').append(
          $("<option></option>")
            .attr('value', address.city)
            .attr('id', address.city_api_id)
            .attr('city_id', address.city_api_id)
            .attr('postal_code', address.postal_code)
            .prop('selected', true)
            .text(address.city)
        );
        $('#city-select').each(getCostByCity);
        $('#postal_code-input').val(address.postal_code);
      });
    } else {
      $('#address_name-input').val('');
      $('#postal_code-input').val('');
      $('#province-select').prop('disabled', false);
      $('#city-select').prop('disabled', false);
      $('#province-loader').hide();
      $('#city-loader').hide();
      $('#service-loader').hide();
    }
  });

});

</script>
@endsection