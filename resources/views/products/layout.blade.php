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

    <nav class="navbar navbar-expand-md navbar-dark bg-dark pt-3 pb-3">
    <div class="container">
        <a class="navbar-brand" href="{{ route('products.index', ['category_products' => 'a']) }}">My First Shop</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse justify-content-end" id="navbarsExampleDefault">
            <ul class="navbar-nav m-auto">
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('products.index') ? 'active' : '' }}" href="{{ route('products.index', ['category_products' => 'a']) }}">Products</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('homepage.index') ? 'active' : '' }}"  href="{{ route('homepage.index') }}">Home Page <span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('AboutUs.index') ? 'active' : '' }}" href="{{ route('AboutUs.index') }}">About Us</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('contacts.index') ? 'active' : '' }}" href="{{ route('contacts.index') }}">Contact</a>
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

            <form class="">
                <div class="input-group input-group-sm">
                    <input type="text" class="form-control" aria-label="Small" aria-describedby="inputGroup-sizing-sm" placeholder="Search product...">
                    <div class="input-group-append">
                        <button type="button" class="btn btn-primary btn-number">
                            <i class="fa fa-search"></i>
                        </button>
                    </div>
                </div>
                <!-- <form class="d-flex">
        <input class="form-control me-2" type="text" placeholder="Search">
        <button class="btn btn-primary" type="button"><i class="fa fa-search"></i></button>
      </form> -->
            </form>
            <a class="btn btn-success btn-sm ml-3" href="{{ route('carts.index') }}">
              <i class="fa fa-shopping-cart"></i> Cart
              <span class="badge badge-light">3</span>
            </a>
        </div>
    </div>
</nav>

@if(request()->routeIs('products.index'))
<section class="text-center py-5" style="background-color: rgb(233, 236, 239)">
    <div class="container">
        <h1 class="jumbotron-heading">Lorem ipsum</h1>
        <p class="lead text-muted mb-0">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec risus erat, placerat in purus vel, tincidunt pulvinar felis. Integer venenatis, magna sed maximus dapibus, quam eros iaculis ligula, vitae tincidunt turpis sapien vehicula libero. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras dignissim id tortor sit amet molestie....</p>
    </div>
</section>
@endif

    <div class="container">
        @yield('content')
    </div>

    <div class="mt-5 p-4 bg-dark text-white text-center">
      <div class="container">
        <div class="row">
          <div class="col-md-4 pt-4">
            <h2 class="h2 text-success border-bottom pb-3 border-light logo">Shop</h2>
                    <ul class="list-unstyled text-light footer-link-list pt-3">
                      <li class="mb-2"><i class="fa fa-home mr-2"></i>&nbsp;My company</li>
                      <li class="mb-2">
                        <i class="fa fa-envelope mr-2"></i>&nbsp;
                        <a class="text-decoration-none" href="mailto:email@example.com">email@example.com</a>
                      </li>
                      <li class="mb-2">
                        <i class="fa fa-phone mr-2"></i>&nbsp;
                        <a class="text-decoration-none" href="tel:123-456-789">123-456-789</a>
                      </li>
                      <li><i class="fa fa-print mr-2"></i>&nbsp;
                      <a class="text-decoration-none" href="tel:123-456-789">123-456-789</a>
                      </li>
                    </ul>
                </div>

                <div class="col-md-4 pt-4">
                    <h2 class="h2 text-light border-bottom pb-3 border-light">Further Info</h2>
                    <ul class="list-unstyled text-light footer-link-list pt-3">
                        <li class="mb-1"><a class="text-decoration-none" href="#">Products</a></li>
                        <li class="mb-1"><a class="text-decoration-none" href="#">Home Page</a></li>
                        <li class="mb-1"><a class="text-decoration-none" href="#">About Us</a></li>
                        <li class="mb-1"><a class="text-decoration-none" href="#">Shop Locations</a></li>
                        <li><a class="text-decoration-none" href="#">Contact</a></li>
                    </ul>
                </div>

                <div class="col-md-4 pt-4">
                    <h2 class="h2 text-light border-bottom pb-3 border-light">About</h2>
                    <p class="pt-3">Le Lorem Ipsum est simplement du faux texte employé dans la composition et la mise en page avant impression.
                    Le Lorem Ipsum est simplement du faux texte employé dans la composition et la mise en page avant impression.
                    </p>
                </div>

            </div>
            
            <div class="row text-light mb-4">
                <div class="col-12 mb-3">
                    <div class="w-100 my-3 border-top border-light"></div>
                </div>
                <form action="{{ route('products.subscribe') }}" method="POST" class="col-auto ms-auto">
                    <div class="input-group mb-3">
                        @csrf
                        <input type="text" class="form-control" name="email_address" placeholder="Email address">
                        <button type="submit" class="btn btn-success">Subscribe</button>
                    </div>
                </form>
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