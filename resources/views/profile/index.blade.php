@extends('layouts.main')

@section('csrf_token')
<meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('container')
<section class="account">
  <div class="container">
    <div class="row account-row">
      <div class="col-lg-12 col-md-12 col-sm-12 title-account">                
        <h1>Profile</h1>
      </div>
      @if(Auth::user()->google_avi)
        <div class="col-lg-3 col-md-3 col-sm-12 image-account">
          <img src="{{ Auth::user()->google_avi }}" referrerpolicy="no-referrer" class="img-fluid" img-responsive img-thumbnail>
        </div>
      @endif
      <div class="{{ (Auth::user()->google_avi) ? "col-lg-9 col-md-9 " : "col-lg-12 col-md-12 " }} col-sm-12 detail-account col-tabdetail">
        <div class="accdetail form">
          @if(session()->has('success'))
            <div class="alert alert-success" role="alert">
              {{ session('success') }}
            </div>
          @elseif(session()->has('fail'))
          <div class="alert alert-danger" role="alert">
            {{ session('fail') }}
          </div>
          @endif
          <h5>Profile Details</h5>
          <div class="ms-3">
            <div class="mb-2 accname form-group">             
              <label for="accName" class="form-label">Name</label>
              <input type="text" id="accName" class="form-control" name="name_customer" value="{{ Auth::user()->name_customer }}" readonly>
            </div>
            <div class="mb-2 accemail form-group">
              <label for="accEmail" class="form-label">Email</label>            
              <input type="email" id="accEmail" class="form-control" name="email" value="{{ Auth::user()->email }}" readonly>
            </div>
            <div class="mb-2 accphone form-group">
              <label for="accPhone" class="form-label">Phone</label>            
              <input type="tel" id="accPhone" class="form-control" name="phone" value="{{ Auth::user()->phone }}" readonly>
            </div>
          </div>
          <div class="d-flex flex-row-reverse">
            <button data-bs-toggle="modal" data-bs-target="#profileUpdateModal" class="btn btn-primary-native-regular mt-4">
              <span><i class="fa-solid fa-pen-to-square"></i></span> Update Profile              
            </button>
            <button data-bs-toggle="modal" data-bs-target="#passwordUpdateModal" class="btn btn-secondary-native-regular mt-4 me-2">
             <span><i class="fa-solid fa-key"></i></span> Manage Password              
            </button>
          </div>
        </div>
      </div>  
      
      {{-- ADDRESSES --}}
      <div class="col-lg-12 col-md-12 col-sm-12 mt-4">                
        <h2>Addresses</h2>
        <div class="address-row d-flex mt-3">
          @if (count($addresses) > 0)
            @foreach ($addresses as $addy)
            <div class="card address-card mb-3 me-3">
              <div class="card-body d-flex justify-content-between flex-column">
                <div>
                  <h5 class="card-title">{{ $addy->name_address }}</h5>
                  <p class="card-text">{{ $addy->address }}</p>            
                  <p class="card-text">{{ $addy->province }}, {{ $addy->city }}</p>                        
                  <p class="card-text mb-2">{{ $addy->postal_code }}</p>            
                </div>
                <div class="text-end">                  
                  <a href="" class="text-danger me-2" data-bs-toggle="modal" data-bs-target="#deleteAddressModal-{{ $addy->id }}">Delete</a>
                  <a href="/profile/address/update/{{ $addy->id }}" class="text-primary-native">Update</a>
                </div>
              </div>
            </div>                        
            @endforeach            
          @else
          <div class="text-center">
            <h5>You haven't added any addresses.</h5>             
          </div>  
          @endif
        </div>
        <div class="text-end">
          <button class="btn btn-primary-native mt-2" data-bs-toggle="modal" data-bs-target="#addAddressModal"
          @if(count($addresses) >= 3) disabled @endif
          >
            <span class="fa-solid fa-plus me-2"></span>Add Address
          </button>
          @if(count($addresses) >= 3) <p class="text-danger mt-2">Reached the maximum amount of addresses</p> @endif
        </div>
      </div>
    </div>

    {{-- UPDATE PROFILE MODAL --}}  
    @include('partials/modal', [
      'modal_id' => 'profileUpdateModal',
      'modal_title' =>  'Update Profile',
      'include_form' => 'true',
      'form_action' => '/profile/update',
      'form_method' => 'post', 
      'additional_form_method' => 'put',
      'modal_body' => '
      <div class="mb-2 accname form-group">             
        <label for="accName" class="form-label">Name</label>
        <input type="text" id="accName" class="form-control" name="name_customer" value="' . Auth::user()->name_customer . '" required>
      </div>
      <div class="mb-2 accphone form-group">
        <label for="accPhone" class="form-label">Phone</label>            
        <input type="tel" id="accPhone" class="form-control" name="phone" value="' . Auth::user()->phone . '" required>
      </div>
      ',
      'modal_footer' => '
      <button type="submit" class="btn btn-primary-native-regular">Update Profile</button>
      ',
    ])
    
    {{-- UPDATE PASSWORD MODAL --}}  
    @include('partials/modal', [
      'modal_id' => 'passwordUpdateModal',
      'modal_title' => 'Update Password', 
      'include_form' => 'true',
      'form_action' => '/password/update',
      'form_method' => 'post', 
      'additional_form_method' => 'put',
      'modal_body' => '
      <div class="mb-2 accusername form-group">
        <label for="accUsername" class="form-label">Enter New Password</label>            
        <input type="password" id="accNewPass" class="form-control" name="password" required>
      </div>
      <div class="mb-2 accemail form-group">
        <label for="accEmail" class="form-label">Reenter New Password to Confirm</label>            
        <input type="password" id="accRepeatPass" class="form-control" name="password_confirmation" required>
      </div>
      ',
      'modal_footer' => '
      <button type="submit" class="btn btn-primary-native-regular"><span class="fa-solid fa-pen-to-square me-1"></span>Update Password</button>
      ',
    ])

    {{-- DELETE ADDRESS MODAL --}}  
    @if (count($addresses) > 0)
    @foreach($addresses as $addy)
      @include('partials/modal', [
        'modal_id' => 'deleteAddressModal-' . $addy->id,
        'modal_title' => 'Delete Address',
        'include_form' => 'true',
        'form_action' => '/profile/address/destroy/' . $addy->id ,
        'form_method' => 'post', 
        'additional_form_method' => 'delete', 
        'modal_body' => '
        Are you sure to delete address: <strong>' . $addy->name_address . '</strong>?',
        'modal_footer' => '
        <button type="submit" class="btn btn-outline-danger"><span class="fa-regular fa-trash-can me-1"></span>Delete Address</button>
        <button type="button" class="btn btn-primary-native-regular" data-bs-dismiss="modal"><span class="fa-solid fa-pen-to-square me-1"></span>Cancel Delete</button>
        ',
      ])
    @endforeach      
    @endif
    
    {{-- ADD ADDRESS MODAL --}}
    @include('partials/modal', [
      'modal_id' => 'addAddressModal',
      'modal_title' => 'Add Address',
      'include_form' => 'true',
      'form_action' => '/address',
      'form_method' => 'post',
      'modal_body' => '
      <div class="mb-2 address-input form-group">
        <label for="address-input" class="form-label">Address Title</label>            
        <input type="text" id="address-input" class="form-control" name="name_address" placeholder="e.g.: My House, New Office, Mom\'s House etc." required>
      </div>
      <div class="mb-2 address-input form-group">
        <label for="address-input" class="form-label">Main Address</label>            
        <textarea id="address-input" class="form-control" name="address" placeholder="e.g.: Jalan Jendral Sudirman No. 2..." required></textarea>
      </div>
      <div class="mb-2 address-input form-group d-flex flex-column">
        <label for="address-input" class="form-label">Province</label>            
        <select id="province-select" class="form-select" aria-label="Select Province" name="province" required>
          <option hidden disabled selected value>Select Province</option>' .
            $provinces
        .'</select>
      </div>
      <div class="mb-2 address-input form-group d-flex flex-column">
        <label for="address-input" class="form-label">City/District</label>            
        <select id="city-select" class="form-select" aria-label="Select City" name="city" required disabled>
          <option hidden disabled selected value>Select City/District</option>
        </select>
      </div>
      <div class="mb-2 address-input form-group">
        <label for="address-input" class="form-label">Postal Code</label>            
        <input id="postal_code" type="text" id="address-input" class="form-control" name="postal_code" placeholder="e.g.: 13220" required>
      </div>
      ',
      'modal_footer' => '
        <button type="submit" class="btn btn-primary-native-regular"><span class="fa-solid fa-circle-check"></span> Add Address</button>
      ',
    ])

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
  
  
  $('#update-province-select').on("change", function() {
    var selectedProvinceId = $("option:selected", this).attr("province_id");
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

  $('#province-select').select2({
    dropdownParent: $('#addAddressModal')
  });
  
  $('#city-select').select2({
    dropdownParent: $('#addAddressModal')
  });

});
</script>
@endsection