<!DOCTYPE html>
<html>
    <head>
        <title>Laravel 10 CRUD Application</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.0/font/bootstrap-icons.css">
        

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
            <a class="nav-link active" href="{{ route('products.index', ['category_products' => 'kat1']) }}">Products</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="{{ route('homepage.index') }}">Home Page</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="{{ route('AboutUs.index') }}">O nas</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="{{ route('contacts.index') }}">Kontakt</a>
          </li>
        </ul>

        <ul class="navbar-nav ms-auto">
        <li class="nav-item">
            <a class="nav-link" href="{{ route('carts.index') }}">Your cart</a>
        </li>
        </ul>
        <span class="navbar-text">
          Navbar text with an inline element
        </span>
      </div>
    </nav>

        <div class="container">
            @yield('content')
        </div>

      <div class="mt-5 p-4 bg-dark text-white text-center">
        <p>Footer</p>
      </div>
    </body>
</html>