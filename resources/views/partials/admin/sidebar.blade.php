<div class="my-container">
  <!-- SIDEBAR -->
  <div class="my-navbar navi active">
    <ul>
      <li>
        <a href="" class="d-flex justify-content-center">
          <span class="title-logo text-center">
            <img src="" alt="Dermanifest Logo Light">
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
        <a href="">
          <span class="icon"><i class="fa fa-sign-out" aria-hidden="true"></i></span>
          <span class="title">Log Out</span>
        </a>
      </li>
    </ul>
  </div>
  
  <!-- NAVBAR -->
  <div class="main active">
    <div class="topbar sticky-div">
      <div class="toggle active" onclick="toggleMenu();"></div>
      <div class="logout">
        <a href="" class="btn-primary-native">
          <span><i class="fa fa-sign-out" aria-hidden="true"></i></span>
          <span>Log Out</span>
        </a>
      </div>
    </div>
  