@extends('products.layout')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-sm-12 col-12 my-5">
            <div class="card">
                <div class="card-body m-2">
                    <div class="col-xl-12 col-lg-12 col-md-12 d-flex justify-content-between">
                        <h6 class="mt-3 text-primary">Show Promo Code</h6>
                        <a class="btn btn-primary mt-2" href="{{ route('orders.index') }}">
                            << Back to orders</a>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <label for="name" class="my-2">Name<span class="text-danger"> *</span></label>
                            <input type="text" name="name" value="{{ $promoCode->name}}" class="form-control" placeholder="Name">
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <label for="code" class="my-2">Code<span class="text-danger"> *</span></label>
                            <input type="text" name="code" value="{{ $promoCode->code }}" class="form-control" placeholder="Code">
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <label for="content" class="my-2">Content<span class="text-danger"> *</span></label>
                            <textarea class="form-control" name="content" placeholder="Content" rows="3">{{$promoCode->content}}</textarea>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <label for="start_date" class="my-2">Start Date<span class="text-danger"> *</span></label>
                            <input type="date" name="start_date" id="start_date" class="form-control" value="{{$promoCode->start_date}}" placeholder="Start Date">
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <label for="end_date" class="my-2">End Date<span class="text-danger"> *</span></label>
                            <input type="date" name="end_date" id="end_date" class="form-control" value="{{$promoCode->end_date}}" placeholder="End Date">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection