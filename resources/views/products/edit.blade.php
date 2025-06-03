@extends('products.layout')
@section('content')
<div class="container">
    @if ($errors->any())
    <div class="alert alert-danger">
        <strong>Whoops!</strong> There were some problems with your input.<br><br>
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif
    <div class="row my-5">
        <form action="{{ route('products.update',$product->id) }}" method="POST" novalidate>
            @csrf
            @method('PUT')
            <div class="card">
                <div class="card-body m-2">
                    <div class="col-xl-12 col-lg-12 col-md-12 d-flex justify-content-between">
                        <h6 class="mt-3 text-primary">Edit Product</h6>
                        <a class="btn btn-primary mt-2" href="{{ route('carts.order') }}"> Back</a>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <label for="name" class="my-2">Name<span class="text-danger"> *</span></label>
                            <input type="text" name="name" value="{{ $product->name }}" class="form-control" placeholder="Name">
                        </div>
                    </div>

                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <label for="price" class="my-2">Price<span class="text-danger"> *</span></label>
                            <input type="number" step="0.1" name="price" value="{{ $product->price }}" class="form-control" placeholder="Price">
                        </div>
                    </div>

                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <label for="detail" class="my-2">Detail<span class="text-danger"> *</span></label>
                            <textarea class="form-control" style="height:150px" name="detail" placeholder="Detail">{{ $product->detail }}</textarea>
                        </div>
                    </div>

                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <label for="category_products_id" class="my-2">Category Product<span class="text-danger"> *</span></label>
                            <select class="form-control" name="category_products_id">
                                @foreach($categoryProducts as $categoryProduct)
                                    @if($product->category_products_id == $categoryProduct->id)
                                        <option selected>Category {{ $categoryProduct->name_category_product }}</option>
                                    @else
                                        <option value="{{ $categoryProduct->id }}">Category {{ $categoryProduct->name_category_product }}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-xs-12 col-sm-12 col-md-12 text-end">
                        <button type="submit" class="btn btn-primary my-3">Submit</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection