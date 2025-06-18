@extends('products.layout')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-sm-12 col-12 my-5">
            <div class="card">
                <div class="card-body m-3" style="text-align: justify;">
                    {{$statute->content}}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection