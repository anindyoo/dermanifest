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
          <a href="/profile/address/create" class="btn btn-primary-native mt-2">
            <span class="fa-solid fa-plus me-2"></span>Add Address
          </a>
        </div>
      </div>

      {{-- ORDER HISTORY --}}
      <div id="order-history-tab" class="order-history col-lg-12 col-md-12 col-sm-12 mt-4">
        <h2>Order History</h2>
        <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
          <li class="nav-item" role="presentation">
            <button class="nav-link active" id="pills-all-order-tab" data-bs-toggle="pill" data-bs-target="#pills-all-order" type="button" role="tab" aria-controls="pills-all-order" aria-selected="true">All Order</button>
          </li>
          <li class="nav-item" role="presentation">
            <button class="nav-link" id="pills-unpaid-tab" data-bs-toggle="pill" data-bs-target="#pills-unpaid" type="button" role="tab" aria-controls="pills-unpaid" aria-selected="false" tabindex="-1">Unpaid</button>
          </li>
          <li class="nav-item" role="presentation">
            <button class="nav-link" id="pills-waiting-tab" data-bs-toggle="pill" data-bs-target="#pills-waiting" type="button" role="tab" aria-controls="pills-waiting" aria-selected="false" tabindex="-1">Waiting</button>
          </li>
          <li class="nav-item" role="presentation">
            <button class="nav-link" id="pills-delivering-tab" data-bs-toggle="pill" data-bs-target="#pills-delivering" type="button" role="tab" aria-controls="pills-delivering" aria-selected="false" tabindex="-1">Delivering</button>
          </li>
          <li class="nav-item" role="presentation">
            <button class="nav-link" id="pills-completed-tab" data-bs-toggle="pill" data-bs-target="#pills-completed" type="button" role="tab" aria-controls="pills-completed" aria-selected="false" tabindex="-1">Delivering</button>
          </li>
        </ul>
        <div class="tab-content" id="pills-tabContent">
          <div class="tab-pane fade show active" id="pills-all-order" role="tabpanel" aria-labelledby="pills-all-order-tab" tabindex="0">
            <div class="table-responsive">
              <table class="table">
                <thead class="table-light manrope-font">
                  <tr>
                    <th scope="col">No.</th>
                    <th scope="col">Order Id</th>
                    <th scope="col">Date</th>
                    <th scope="col">Total</th>
                    <th scope="col">Status</th>
                    <th scope="col">Action</th>
                  </tr>
                </thead>
                <tbody>
                  @forelse ($orders as $order)
                  <tr>
                    <th scope="row" class="manrope-font">{{ $loop->iteration }}.</th>
                    <td>{{ $order->id }}</td>
                    <td>{{ $order->created_at }} WIB</td>
                    <td>{{ $order->grand_total }}</td>
                    <td>@include('partials.status', ['status' => $order->status])</td>
                    <td>
                      <a href="/order/{{ $order->id }}" class="btn btn-info"><i class="fa-solid fa-circle-info"></i> detail</a>
                    </td>
                  </tr>                    
                  @empty
                  <tr>
                    <td colspan="100%" class="text-center">
                      <h5>You have no orders, yet.</h5>
                    </td>
                  </tr>
                  @endforelse
                </tbody>
              </table>
            </div>
          </div>
          <div class="tab-pane fade" id="pills-unpaid" role="tabpanel" aria-labelledby="pills-unpaid-tab" tabindex="0">
            Unpaid
          </div>
          <div class="tab-pane fade" id="pills-waiting" role="tabpanel" aria-labelledby="pills-waiting-tab" tabindex="0">
            Waiting
          </div>
          <div class="tab-pane fade" id="pills-delivering" role="tabpanel" aria-labelledby="pills-delivering-tab" tabindex="0">
            Delivering
          </div>
          <div class="tab-pane fade" id="pills-completed" role="tabpanel" aria-labelledby="pills-completed-tab" tabindex="0">
            Completed
          </div>
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
        <input type="text" id="accName-update" class="form-control" name="name_customer" value="' . Auth::user()->name_customer . '" required>
      </div>
      <div class="mb-2 accphone form-group">
        <label for="accPhone" class="form-label">Phone</label>            
        <input type="tel" id="accPhone-update" class="form-control" name="phone" value="' . Auth::user()->phone . '" required>
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
    
  </div>
</section>
@endsection
