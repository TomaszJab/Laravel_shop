<!DOCTYPE html>
<html>
    <head>
        <title>Laravel 10 CRUD Application</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.0/font/bootstrap-icons.css">

        <nav class="navbar navbar-expand-lg bg-light">

  <div class="container">
    <a class="navbar-brand" href="{{ route('products.index') }}">Products</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon">bb</span>
    </button>
    <div class="collapse navbar-collapse" id="navbarText">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="{{ route('AboutUs.index') }}">O nas</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="{{ route('contacts.index') }}">Kontakt</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">Promocje</a>
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
  </div>
</nav>
<link href="/css/layout.css" rel="stylesheet">
    </head>

    <body> 
        <div class="container">
            @yield('content')
        </div>
    </body>
</html>