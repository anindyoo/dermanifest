<div class="my-container">
  <!-- SIDEBAR -->
  <div class="my-navbar navi active">
    <ul>
      <li>
        <a href="/admin" class="d-flex justify-content-center">
          <span class="title-logo text-center">
            <img src="{{ asset('img/logo-light.svg') }}" alt="Dermanifest Logo Light">
            <h3 class="text-light">Admin Page</h3>
          </span>
        </a>
      </li>
      <li>
        <a href="/admin" class="{{ (Request::is('admin') ? 'link-active' : '') }}">
          <span class="icon"><i class="fa fa-home" aria-hidden="true"></i></span>
          <span class="title">Home</span>
        </a>
      </li>
      <li>
        <a href="/admin/categories" class="{{ (Request::is('admin/categories*') ? 'link-active' : '') }}">
          <span class="icon"><i class="fa fa-solid fa-tags" aria-hidden="true"></i></span>
          <span class="title">Categories</span>
        </a>
      </li>
      <li>
        @if(Request::is('admin/products*') OR Request::is('admin/pictures*'))
        <a href="/admin/products" class="link-active">
        @else
        <a href="/admin/products">
        @endif
          <span class="icon"><i class="fa fas fa-shopping-bag" aria-hidden="true"></i></span>  
          <span class="title">Products</span>
        </a>
      </li>
      <li>
        <a href="/admin/top_products" class="{{ (Request::is('admin/top_products*') ? 'link-active' : '') }}">
          <span class="icon"><i class="fa fa-solid fa-medal" aria-hidden="true"></i></span>
          <span class="title">Top Products</span>
        </a>
      </li>
      <li>
        <a href="/admin/orders" class="{{ (Request::is('admin/orders*') ? 'link-active' : '') }}">
          <span class="icon"><i class="fa-solid fa-cart-shopping fa-lg" aria-hidden="true"></i></span>
          <span class="title">Orders Management</span>
        </a>
      </li>
      <li>
        <a href="/admin/completed_orders" class="{{ (Request::is('admin/completed_orders*') ? 'link-active' : '') }}">
          <span class="icon"><i class="fa-solid fa-circle-check fa-lg" aria-hidden="true"></i></span>
          <span class="title">Completed Orders</span>
        </a>
      </li>
      <li>
        <a href="/admin/customers" class="{{ (Request::is('admin/customers*') ? 'link-active' : '') }}">
          <span class="icon"><i class="fa-solid fa-user-group fa-lg" aria-hidden="true"></i></span>
          <span class="title">Completed Orders</span>
        </a>
      </li>
      <li>
        <form action="/logout" method="post" class="nav-link">
          @csrf
          <button type="submit" class="logout-button">
            <span class="icon"><i class="fa fa-sign-out" aria-hidden="true"></i></span>
            <span class="title">Log Out</span>
          </button>
        </form>
      </li>
    </ul>
  </div>
  
  <!-- NAVBAR -->
  <div class="main active">
    <div class="topbar sticky-div">
      <div class="toggle active" onclick="toggleMenu();"></div>
      <div class="logout">
        <form action="/logout" method="post" class="nav-link">
          @csrf
          <button type="submit" class="btn-primary-native-regular pe-2 ps-2 pb-1 pt-1 rounded-1">
            <span><i class="fa fa-sign-out" aria-hidden="true"></i></span>
            <span>Log Out</span>
          </button>
        </form>
      </div>
    </div>
  