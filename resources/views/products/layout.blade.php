<!DOCTYPE html>
<html>
    <head>
        <title>Laravel 10 Shop Application</title>
        
        <!-- Bootstrap 5.3.3 CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
        <!-- Bootstrap 5.3.3 JS -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>


        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.0/font/bootstrap-icons.css">

        <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>

        <link href="/css/layout.css" rel="stylesheet">
    </head>

    <body> 

    <div class="p-5 bg-primary text-white text-center">
      <h1>My First Laravel project</h1>
      <p>Tell me about your impressions!</p> 
    </div>

    <nav class="navbar navbar-expand-sm bg-dark navbar-dark">
      <div class="container-fluid">
        <ul class="navbar-nav">
          <li class="nav-item">
            <a class="nav-link active" href="{{ route('products.index', ['category_products' => 'a']) }}">Products</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="{{ route('homepage.index') }}">Home Page</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="{{ route('AboutUs.index') }}">About Us</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="{{ route('contacts.index') }}">Contact</a>
          </li>
        </ul>

        <ul class="navbar-nav ms-auto">
        <li class="nav-item">
            <a class="nav-link" href="{{ route('carts.index') }}">Your cart</a>
        </li>

        @if (Route::has('login'))
          @auth
            <li class="nav-item">
              <a class="nav-link" href="{{ url('/dashboard') }}">dashboard</a>
            </li>
          @else
            <li class="nav-item">
              <a class="nav-link" href="{{ route('login') }}">Login</a>
            </li>
            @if (Route::has('register'))
              <li class="nav-item">
                <a class="nav-link" href="{{ route('register') }}">Register</a>
              </li>
            @endif
          @endauth
        @endif

        </ul>
        <!-- <span class="navbar-text">
          Navbar text with an inline element
        </span> -->
      </div>
    </nav>

    <div class="container">
        @yield('content')
    </div>

    <div class="mt-5 p-4 bg-dark text-white text-center">
      <div class="container">
        <div class="row">
          <div class="col-md-4 pt-4">
            <h2 class="h2 text-success border-bottom pb-3 border-light logo">Zay Shop</h2>
                    <ul class="list-unstyled text-light footer-link-list">
                        <li>
                            <i class="fas fa-map-marker-alt fa-fw"></i>
                            123 Consectetur at ligula 10660
                        </li>
                        <li>
                            <i class="fa fa-phone fa-fw"></i>
                            <a class="text-decoration-none" href="tel:010-020-0340">010-020-0340</a>
                        </li>
                        <li>
                            <i class="fa fa-envelope fa-fw"></i>
                            <a class="text-decoration-none" href="mailto:info@company.com">info@company.com</a>
                        </li>
                    </ul>
                </div>

                <div class="col-md-4 pt-4">
                    <h2 class="h2 text-light border-bottom pb-3 border-light">Products</h2>
                    <ul class="list-unstyled text-light footer-link-list">
                        <li><a class="text-decoration-none" href="#">Luxury</a></li>
                        <li><a class="text-decoration-none" href="#">Sport Wear</a></li>
                        <li><a class="text-decoration-none" href="#">Men's Shoes</a></li>
                        <li><a class="text-decoration-none" href="#">Women's Shoes</a></li>
                        <li><a class="text-decoration-none" href="#">Popular Dress</a></li>
                        <li><a class="text-decoration-none" href="#">Gym Accessories</a></li>
                        <li><a class="text-decoration-none" href="#">Sport Shoes</a></li>
                    </ul>
                </div>

                <div class="col-md-4 pt-4">
                    <h2 class="h2 text-light border-bottom pb-3 border-light">Further Info</h2>
                    <ul class="list-unstyled text-light footer-link-list">
                        <li><a class="text-decoration-none" href="#">Products</a></li>
                        <li><a class="text-decoration-none" href="#">Home Page</a></li>
                        <li><a class="text-decoration-none" href="#">About Us</a></li>
                        <li><a class="text-decoration-none" href="#">Shop Locations</a></li>
                        <li><a class="text-decoration-none" href="#">Contact</a></li>
                    </ul>
                </div>

            </div>

            <div class="row text-light mb-4">
                <div class="col-12 mb-3">
                    <div class="w-100 my-3 border-top border-light"></div>
                </div>
                <div class="col-auto ms-auto">
                    <div class="input-group mb-3">
                      <input type="text" class="form-control" placeholder="Email address" aria-label="Recipient's username" aria-describedby="button-addon2">
                      <button class="btn btn-success" type="button" id="button-addon2">Subscribe</button>
                    </div>
                </div>
            </div>
        </div>
      </div>
      <div class="w-100 bg-black py-3">
        <div class="container">
          <div class="row pt-2">
            <div class="col-12">
              <p class="text-left text-light">Company Name | Designed by <a href="#">Company Name</a></p>
            </div>
          </div>
        </div>
      </div>
    </body>
</html>