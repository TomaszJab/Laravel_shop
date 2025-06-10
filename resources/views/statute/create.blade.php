@extends('products.layout')
@section('content')
<div class="container">
    <div class="row my-5">
        <form action="{{ route('statutes.store') }}" method="POST">
        @csrf
            <div class="card">
                <div class="card-body m-2">
                    <div class="col-xl-12 col-lg-12 col-md-12 d-flex justify-content-between">
                        <h6 class="mt-3 text-primary">Add New Statute</h6>
                        <a class="btn btn-primary mt-2" href="{{ route('orders.index') }}"><< Back to orders</a>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <label for="name" class="my-2">Name<span class="text-danger"> *</span></label>
                            <input type="text" name="name" class="form-control" placeholder="Name">
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <label for="detail" class="my-2">Detail<span class="text-danger"> *</span></label>
                            <textarea class="form-control" style="height:150px" name="detail" placeholder="Detail"></textarea>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <label for="valid" class="my-2">Valid<span class="text-danger"> *</span></label>
                            <select class="form-control" name="valid">
                                <option value="">--- Select Valid ---</option>
                                <option value="1">Yes</option>
                                <option value="0">No</option>
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