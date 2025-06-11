@extends('products.layout')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-sm-12 col-12 my-5">
            <div class="card">
                <div class="card-body m-3" style="text-align: justify;">
                    @foreach ($statudes as $statude)
                    {{$statude->id}}
                    {{$statude->content}}
                    {{$statude->valid}}
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection