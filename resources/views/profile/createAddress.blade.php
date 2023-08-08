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
          <h5 class="modal-title">Add New Address</h5>
        </div>
        <form action="/profile/address/create" method="post">
          @csrf
          <div class="modal-body">
            <div class="mb-2 address-input form-group">
              <label for="address-input" class="form-label">Address Title</label>            
              <input type="text" id="address-input" class="form-control" name="name_address" value="" required>
            </div>
            <div class="mb-2 address-input form-group">
              <label for="address-input" class="form-label">Main Address</label>            
              <textarea id="address-input" class="form-control" name="address" required></textarea>
            </div>
            <div class="mb-2 address-input form-group d-flex flex-column">
              <label for="address-input" class="form-label">Province</label>   
              <input id="province_id-input" type="hidden" name="province_api_id" required>         
              <select id="province-select" class="form-select" aria-label="Select Province" name="province" required>
                <option hidden disabled selected value>Select Province</option>
                  {!! $provinces !!}
                </select>
            </div>
            <div class="mb-2 address-input form-group d-flex flex-column">
              <label for="address-input" class="form-label">City/District</label>    
              <input id="city_id-input" type="hidden" name="city_api_id" required>                 
              <select id="city-select" class="form-select" aria-label="Select City" name="city" required disabled>
                <option hidden disabled selected value>Select City/District</option>
              </select>
            </div>
            <div class="mb-2 address-input form-group">
              <label for="address-input" class="form-label">Postal Code</label>            
              <input type="text" id="address-input" class="form-control" name="postal_code" value="" required>
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

  $('#province-select').change(function () {
    $('#city-select').removeAttr('disabled');
  })

  // Get City Based on Province
  $('#province-select').on("change", function() {
    var selectedProvinceId = $("option:selected", this).attr("province_id");
    $('#province_id-input').val(selectedProvinceId);
    $.ajax({
      type: 'post',
      url: '/citiesByProvinceId/' + selectedProvinceId,
      data: {},
    }).done(function(cities) {           
      $('#city-select').find('option').remove().end()
        .append('<option hidden disabled selected value>Select City/District</option>');
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

  $('#city-select').on("change", function() {
    var selectedCityId = $("option:selected", this).attr("city_id");
    $('#city_id-input').val(selectedCityId);
  });
  
  $('#city-select').select2();

});
</script>
@endsection