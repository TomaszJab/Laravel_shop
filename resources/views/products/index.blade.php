@extends('products.layout')
@section('content')
<!-- <div class="row">
  <div class="col-lg-12 mt-4 text-end">
      <a class="btn btn-success" href="{{ route('products.create') }}"> Create New Product</a>
  </div>
</div> -->
<!-- align-items-center -->
<div class="row ">
  <div class="col-6 col-md-6 mt-3">
    <p class="fs-3">Categories</p>
  </div>
  <div class="col-6 col-md-6 mt-4">
    <select class="form-select w-75 ms-auto" onchange="location.href = updateURL(this.value);">
      <option value="">Featured</option>
      <option value="desc" {{ request('sortOption') == 'desc' ? 'selected' : '' }}>Malejąco</option>
      <option value="asc" {{ request('sortOption') == 'asc' ? 'selected' : '' }}>Rosnąco</option>
    </select>
  </div>
</div>

<script>
    function updateURL(sortOption) {
        const url = new URL(window.location.href);
        url.searchParams.set('sortOption', sortOption);
        return url.href;
    }
</script>

<div class="row">
  <div class="col-md-3 mt-0">
    <div class="list-group">
      <a href="{{ route('products.index', ['category_products' => 'a']) }}" class="list-group-item list-group-item-action {{ (request()->query('category_products') == 'a') ? 'active' : '' }}">Category a</a>
      <a href="{{ route('products.index', ['category_products' => 'b']) }}" class="list-group-item list-group-item-action {{ (request()->query('category_products') == 'b') ? 'active' : '' }}">Category b</a>
      <a href="{{ route('products.index', ['category_products' => 'c']) }}" class="list-group-item list-group-item-action {{ (request()->query('category_products') == 'c') ? 'active' : '' }}">Category c</a>
      <a href="{{ route('products.index', ['category_products' => 'd']) }}" class="list-group-item list-group-item-action {{ (request()->query('category_products') == 'd') ? 'active' : '' }}">Category d</a>
    </div>
  </div>

  <div class="col-md-9 mt-0">
    <div class="row">
      @foreach ($products as $product)
      <div class="col-md-4 mt-0">
        <div class="card">
          <img src="https://themewagon.github.io/zay-shop/assets/img/shop_01.jpg" class="card-img-top" alt="...">
          <div class="card-body">
            <h5 class="card-title">{{ $product->name }}</h5>
            <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
            <a href="#" class="btn btn-primary">Go somewhere</a>
          </div>
        </div>
      </div>
      @endforeach
    </div>
  </div>
</div>

<div class="row">
  <div class="col-md-2 ms-auto d-flex justify-content-end fs-4 mt-4 pagination">
    {!! $products->links() !!}
  </div>
</div>

<div class="row">
  <div class="col-md-12 mt-4">
    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif
    <table class="table table-bordered">
        <tr>
            <th>Name</th>
            <th>Price</th>
            <th>Details</th>
            <th width="280px">Action</th>
        </tr>
        @foreach ($products as $product)
        <tr>
           
            <td>{{ $product->name }}</td>
            <td>{{ $product->price }}</td>
            <td>{{ $product->detail }}</td>
            <td>
                <form action="{{ route('products.destroy', $product -> id) }}" method="POST">
                    <a class="btn btn-info" href="{{ route('products.show', $product -> id) }}">Show</a>
                    <a class="btn btn-primary" href="{{ route('products.edit', $product -> id) }}">Edit</a>
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
            </td>
        </tr>
        @endforeach
    </table>

    <!-- {!! $products->links() !!} -->
    </div>
</div>
@endsection