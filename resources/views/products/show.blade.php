@extends('products.layout')
@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2> Show Product</h2>
            </div>
        </div>
        <div class="col-lg-12 mb-3">
            <div class="text-end">
                <a class="btn btn-warning" href="{{ route('products.index') }}"> Back</a>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Name:</strong>
                {{ $product->name }}
            </div>
        </div>

        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Price:</strong>
                {{ $product->price }}
            </div>
        </div>

        <div class="col-xs-10 col-sm-10 col-md-10">
            <div class="form-group">
                <strong>Details:</strong>
                {{ $product->detail }}
            </div>
        </div>

        <div class="col-xs-2 col-sm-2 col-md-2 text-end">
        <form action="{{ route('products.add_to_cart', $product->id) }}" method="POST">
            @csrf
            <button type="submit" class="btn btn-primary">Add to cart</button>
        </form>
        </div>
    </div>

    <h3>Add comment</h3>

    <form action="{{ route('products.comments.store', ['product' => $product->id]) }}" method="POST">
    @csrf
     <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Author:</strong>
                <input type="text" name="author" class="form-control" placeholder="Author">
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Content:</strong>
                <textarea class="form-control" style="height:150px" name="content" placeholder="Content"></textarea>
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                <button type="submit" class="btn btn-primary">Add Comment</button>
        </div>
    </div>
</form>
<h3>Comments</h3>
<ul>
    @foreach ($product->comments as $comment)
        <li>
            <strong>{{ $comment->author }}</strong>: {{ $comment->content }}
        </li>
    @endforeach
</ul>

@endsection