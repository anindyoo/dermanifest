@if(Auth::user()->id != $address_data->customer_id)
<script>window.location = "/profile";</script>

@elseif(Auth::user()->id == $address_data->customer_id)
@extends('layouts.header')

@section('csrf_token')
<meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

  @section('content')
<section>
  <div class="modal position-static d-block" tabindex="-1">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Modal title</h5>
        </div>
        <form action="/profile/address/update/{{ $address_data->id }}" method="post">
          @method('put')
          @csrf
          <div class="modal-body">
            <div class="mb-2 address-input form-group">
              <label for="address-input" class="form-label">Address Title</label>            
              <input type="text" id="address-input" class="form-control" name="name_address" value="{{ $address_data->name_address }}" required>
            </div>
            <div class="mb-2 address-input form-group">
              <label for="address-input" class="form-label">Main Address</label>            
              <textarea id="address-input" class="form-control" name="address" required>{{ $address_data->address }}</textarea>
            </div>
            <div class="mb-2 address-input form-group d-flex flex-column">
              <label for="address-input" class="form-label">Province</label>
                <input id="province_id-input" type="hidden" name="province_api_id" value="{{ $address_data->province_api_id }}" required>         
                <select id="update-province-select" class="form-select" aria-label="Select Province" name="province" required>
                  <option province_id="{{ $address_data->province_api_id }}" value="{{ $address_data->province }}" selected>{{ $address_data->province }}</option>        
                  {!! $provinces !!}
                </select>
            </div>
            <div class="mb-2 address-input form-group d-flex flex-column">
              <label for="address-input" class="form-label">City</label> 
              <input id="city_id-input" type="hidden" name="city_api_id" value="{{ $address_data->city_api_id }}" required>         
              <select id="update-city-select" class="form-select" aria-label="Select City" name="city" required>
                <option city_id="{{ $address_data->city_api_id }}" value="{{ $address_data->city }}" selected>{{ $address_data->city }}</option>        
              </select>
            </div>
            <div class="mb-2 address-input form-group">
              <label for="address-input" class="form-label">Postal Code</label>            
              <input type="text" id="address-input" class="form-control" name="postal_code" value="{{ $address_data->postal_code }}" required>
            </div>
          </div>
          <div class="modal-footer">
            <a href="/profile" class="btn btn-secondary-native" data-bs-dismiss="modal">Back to Profile</a>
            <button type="submit" class="btn btn-primary-native">Save changes</button>
          </div>
        </form>
      </div>
    </div>
  </div>
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

  // Get City Based on Province
  var selectedProvinceId = $("option:selected", this).attr("province_id");
  $.ajax({
    type: 'post',
    url: '/citiesByProvinceId/' + selectedProvinceId,
    data: {},
  }).done(function(cities) {
    $.each(cities, function(key, city) { 
      $('#update-city-select').append(
        $("<option></option>")
        .attr("value", city['type'] + ' ' + city['city_name'])
        .attr("id", city['city_id'])
        .attr("city_id", city['city_id'])
        .attr("postal_code", city['postal_code'])
        .text(city['type'] + ' ' + city['city_name'])
      );
    });
  });

  $('#update-province-select').on("change", function() {
    var selectedProvinceId = $("option:selected", this).attr("province_id");
    $('#province_id-input').val(selectedProvinceId);
    $.ajax({
      type: 'post',
      url: '/citiesByProvinceId/' + selectedProvinceId,
      data: {},
    }).done(function(cities) {           
      $('#update-city-select').find('option').remove().end()
        .append('<option hidden disabled selected value>Select City/District</option>');
      $.each(cities, function(key, city) {   
        $('#update-city-select').append(
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

  $('#update-city-select').on("change", function() {
    var selectedCityId = $("option:selected", this).attr("city_id");
    $('#city_id-input').val(selectedCityId);
  });

  $('#update-province-select').select2();
  
  $('#update-city-select').select2();
}); 
</script>
@endsection
@endif