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
        <form action="{{ route('promoCode.store') }}" method="POST">
            @csrf
            <div class="card">
                <div class="card-body m-2">
                    <div class="col-xl-12 col-lg-12 col-md-12 d-flex justify-content-between">
                        <h6 class="mt-3 text-primary">Add New Promo Code</h6>
                        <a class="btn btn-primary mt-2" href="{{ route('orders.index') }}">
                            << Back to orders</a>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <label for="name" class="my-2">Name<span class="text-danger"> *</span></label>
                            <input type="text" name="name" value="{{old('name')}}" class="form-control" placeholder="Name">
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <label for="code" class="my-2">Code<span class="text-danger"> *</span></label>
                            <input type="text" name="code" value="{{old('code')}}" class="form-control" placeholder="Code">
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <label for="content" class="my-2">Content<span class="text-danger"> *</span></label>
                            <textarea class="form-control" name="content" placeholder="Content" rows="3">{{old('content')}}</textarea>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <label for="start_date" class="my-2">Start Date<span class="text-danger"> *</span></label>
                            <input type="date" name="start_date" id="start_date" class="form-control" value="{{old('start_date')}}" placeholder="Start Date">
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <label for="end_date" class="my-2">End Date<span class="text-danger"> *</span></label>
                            <input type="date" name="end_date" id="end_date" class="form-control" value="{{old('end_date')}}" placeholder="End Date">
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