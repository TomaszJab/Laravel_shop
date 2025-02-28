@extends('products.layout')
@section('content')


<div id="myCarousel" class="carousel slide" data-bs-ride="carousel">
    <div class="carousel-indicators">
      <button type="button" data-bs-target="#myCarousel" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
      <button type="button" data-bs-target="#myCarousel" data-bs-slide-to="1" aria-label="Slide 2"></button>
      <button type="button" data-bs-target="#myCarousel" data-bs-slide-to="2" aria-label="Slide 3"></button>
    </div>
    <div class="carousel-inner" style="height: 600px;">
      <div class="carousel-item active" style="height: 100%;">
        <svg class="bd-placeholder-img" width="100%" height="100%" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" preserveAspectRatio="xMidYMid slice" focusable="false"><rect width="100%" height="100%" fill="#777"/></svg>

        <div class="container">
          <div class="carousel-caption text-start">
            <h1>Donec risus sus.</h1>
            <p>Donec risus erat, placerat in purus vel, tincidunt pulvinar felis. ar felis.</p>
            <p><a class="btn btn-lg btn-primary" href="#">Sign up today</a></p>
          </div>
        </div>
      </div>
      <div class="carousel-item" style="height: 100%;">
        <svg class="bd-placeholder-img" width="100%" height="100%" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" preserveAspectRatio="xMidYMid slice" focusable="false"><rect width="100%" height="100%" fill="#777"/></svg>

        <div class="container">
          <div class="carousel-caption">
            <h1>Donec risus er, placerat.</h1>
            <p>Donec risus erat, placerat in purus vel, tincidunt pulvinar felis. ar felis.</p>
            <p><a class="btn btn-lg btn-primary" href="#">Learn more</a></p>
          </div>
        </div>
      </div>
      <div class="carousel-item" style="height: 100%;">
        <svg class="bd-placeholder-img" width="100%" height="100%" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" preserveAspectRatio="xMidYMid slice" focusable="false"><rect width="100%" height="100%" fill="#777"/></svg>

        <div class="container">
          <div class="carousel-caption text-end">
            <h1>Donec risus erat, placerat.</h1>
            <p>Donec risus erat, placerat in purus vel, tincidunt pulvinar felis. ar felis.</p>
            <p><a class="btn btn-lg btn-primary" href="#">Browse gallery</a></p>
          </div>
        </div>
      </div>
    </div>
    <button class="carousel-control-prev" type="button" data-bs-target="#myCarousel" data-bs-slide="prev">
      <span class="carousel-control-prev-icon" aria-hidden="true"></span>
      <span class="visually-hidden">Previous</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#myCarousel" data-bs-slide="next">
      <span class="carousel-control-next-icon" aria-hidden="true"></span>
      <span class="visually-hidden">Next</span>
    </button>
  </div>

<div class="container marketing">

<!-- START THE FEATURETTES -->

<div class="row featurette mt-5">
  <div class="col-md-7">
    <h2 class="featurette-heading">Lorem ipsum dolor sit amet. <span class="text-muted">Lorem ipsum dolor.</span></h2>
    <p class="lead">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec risus erat, placerat in purus vel, tincidunt pulvinar felis. </p>
  </div>
  <div class="col-md-5">
    <svg class="bd-placeholder-img bd-placeholder-img-lg featurette-image img-fluid mx-auto" width="500" height="500" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Placeholder: 500x500" preserveAspectRatio="xMidYMid slice" focusable="false"><title>Placeholder</title><rect width="100%" height="100%" fill="#eee"/><text x="50%" y="50%" fill="#aaa" dy=".3em">500x500</text></svg>

  </div>
</div>

<hr class="featurette-divider mt-5 mb-5">

<div class="row featurette">
  <div class="col-md-7 order-md-2">
    <h2 class="featurette-heading">Lorem ipsum dolor sit amet. <span class="text-muted">Lorem ipsum dolor.</span></h2>
    <p class="lead">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec risus erat, placerat in purus vel, tincidunt pulvinar felis. Donec risus erat, placerat in purus vel, tincidunt pulvinar felis.</p>
  </div>
  <div class="col-md-5 order-md-1">
    <svg class="bd-placeholder-img bd-placeholder-img-lg featurette-image img-fluid mx-auto" width="500" height="500" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Placeholder: 500x500" preserveAspectRatio="xMidYMid slice" focusable="false"><title>Placeholder</title><rect width="100%" height="100%" fill="#eee"/><text x="50%" y="50%" fill="#aaa" dy=".3em">500x500</text></svg>

  </div>
</div>

<hr class="featurette-divider mt-5 mb-5">

<div class="row featurette">
  <div class="col-md-7">
    <h2 class="featurette-heading">Lorem ipsum dolor sit amet. <span class="text-muted">Lorem ipsum dolor.</span></h2>
    <p class="lead">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec risus erat, placerat in purus vel, tincidunt pulvinar felis. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec risus erat, placerat in purus vel, tincidunt pulvinar felis. </p>
  </div>
  <div class="col-md-5">
    <svg class="bd-placeholder-img bd-placeholder-img-lg featurette-image img-fluid mx-auto" width="500" height="500" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Placeholder: 500x500" preserveAspectRatio="xMidYMid slice" focusable="false"><title>Placeholder</title><rect width="100%" height="100%" fill="#eee"/><text x="50%" y="50%" fill="#aaa" dy=".3em">500x500</text></svg>

  </div>
</div>
<hr class="featurette-divider mt-5 mb-5">
<!-- Three columns of text below the carousel -->

<div class="row">
  <div class="col-lg-6 mb-3">
    <div class="card">
      <svg class="bd-placeholder-img d-block mx-auto card-img-top" width="400" height="400" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Placeholder: 140x140" preserveAspectRatio="xMidYMid slice" focusable="false"><title>Placeholder</title><rect width="100%" height="100%" fill="#eee"/><text x="50%" y="50%" fill="#aaa" dy=".3em"></text></svg>
      <div class="card-body">
        <h2>Category 1</h2>
        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
        <p><a class="btn btn-primary" href="#">View details &raquo;</a></p>
      </div>
    </div>
  </div><!-- /.col-lg-4 -->

  <div class="col-lg-6 mb-3">
  <div class="card">
      <svg class="bd-placeholder-img d-block mx-auto card-img-top" width="400" height="400" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Placeholder: 140x140" preserveAspectRatio="xMidYMid slice" focusable="false"><title>Placeholder</title><rect width="100%" height="100%" fill="#eee"/><text x="50%" y="50%" fill="#aaa" dy=".3em"></text></svg>
      <div class="card-body">
    <h2>Category 2</h2>
    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
    <p><a class="btn btn-primary" href="#">View details &raquo;</a></p>
    </div>
    </div>
  </div><!-- /.col-lg-4 -->

  <div class="col-lg-6 mb-3">
  <div class="card">
      <svg class="bd-placeholder-img d-block mx-auto card-img-top" width="400" height="400" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Placeholder: 140x140" preserveAspectRatio="xMidYMid slice" focusable="false"><title>Placeholder</title><rect width="100%" height="100%" fill="#eee"/><text x="50%" y="50%" fill="#aaa" dy=".3em"></text></svg>
      <div class="card-body">
    <h2>Category 3</h2>
    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
    <p><a class="btn btn-primary" href="#">View details &raquo;</a></p>
    </div>
    </div>
  </div><!-- /.col-lg-4 -->

  <div class="col-lg-6 mb-3">
  <div class="card">
      <svg class="bd-placeholder-img d-block mx-auto card-img-top" width="400" height="400" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Placeholder: 140x140" preserveAspectRatio="xMidYMid slice" focusable="false"><title>Placeholder</title><rect width="100%" height="100%" fill="#eee"/><text x="50%" y="50%" fill="#aaa" dy=".3em"></text></svg>
      <div class="card-body">
    <h2>Category 4</h2>
    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. </p>
    <p><a class="btn btn-primary" href="#">View details &raquo;</a></p>
    </div>
    </div>
  </div><!-- /.col-lg-4 -->
</div><!-- /.row -->

<!-- /END THE FEATURETTES -->

</div><!-- /.container -->
@endsection