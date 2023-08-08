<section class="navbar-fixed-top">
  <div class="container">
    <nav class="navbar navbar-expand-lg navbar-light nav-dermanifest">
      <div class="container-fluid">
        <a class="navbar-brand nav-logo" href="/"><img src="../img/logo-dark.svg" alt="" srcset=""></a>
      </div>

      <button class="navbar-toggler nav-toggle" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <i class='bx bx-dots-horizontal-rounded nav-mobile-menu' ></i>
      </button>

      <li class="navbar-toggler nav-toggle">
        <a class="nav-link" href="/cart"><i class='bx bx-cart'></i></a>
      </li>
      <div class="collapse navbar-collapse dorpdown-mobile" id="navbarSupportedContent">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
          <li class="nav-item me-4">
            <a class="nav-link" href="/">Home</a>
          </li>
          <li class="nav-item me-4">
            <a class="nav-link" href="#">About</a>
          </li>
          <li class="nav-item me-4 dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              Shop
            </a>
            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
              <li><a class="dropdown-item" href="/products">All Product</a></li>
              @foreach ($global_categories as $category)              
              <li><a class="dropdown-item" href="/products#{{ $category->name_category }}">{{ $category->name_category }}</a></li>
              @endforeach
            </ul>
          </li>
          <li class="nav-item me-4">
            <a class="nav-link" href="#">Contact</a>
          </li>
          
          <div class="nav-ico-mobile">
            <li class="nav-item me-4 cart-nav hide-med">
              <a class="nav-link" href="/cart"><i class='bx bx-cart'></i></a>
              <span class='badge badge-warning' id='lblCartCount'>
                @if (session()->has('cart'))
                  {{ session()->get('cart')['quantity_total'] }}
                @else
                  0
                @endif
              </span>
            </li>
            <li class="nav-item me-4">
              <a class="nav-link" href="/profile"><i class='bx bx-user' ></i></a>
            </li>
            @auth('web')
              <li class="nav-item me-4">
                <form action="/logout" method="post" class="nav-link">
                  @csrf
                  <button type="submit" class="logout-button">Logout</button>
                </form>
              </li>            
            @endauth
            @auth('admin')
              <li class="nav-item me-4">
                <form action="/logout" method="post" class="nav-link">
                  @csrf
                  <button type="submit" class="logout-button">Logout</button>
                </form>
              </li>            
            @endauth
          </div>
        </ul>
      </div>
    </nav>
  </div>
</section>
<script>
window.addEventListener('scroll', function() {
  let header = document.querySelector('.navbar-fixed-top');
  let windowChecker = window.scrollY > 0;
  header.classList.toggle('scrolling-active', windowChecker);
})
</script>
<div class="whitespace"></div>