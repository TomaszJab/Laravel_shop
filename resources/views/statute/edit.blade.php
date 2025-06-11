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
        <form action="{{ route('statutes.update',$statute->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="card">
                <div class="card-body m-2">
                    <div class="col-xl-12 col-lg-12 col-md-12 d-flex justify-content-between">
                        <h6 class="mt-3 text-primary">Add New Statute</h6>
                        <a class="btn btn-primary mt-2" href="{{ route('orders.index') }}">
                            << Back to orders</a>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <label for="name" class="my-2">Name<span class="text-danger"> *</span></label>
                            <input type="text" name="name" value="{{old('name',$statute->name)}}" class="form-control" placeholder="Name">
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <label for="content" class="my-2">Content<span class="text-danger"> *</span></label>
                            <textarea class="form-control" style="height:150px" name="content" placeholder="Content">{{old('content',$statute->content)}}</textarea>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <label for="valid" class="my-2">Valid<span class="text-danger"> *</span></label>
                            <select class="form-control" name="valid">
                                <option value="">--- Select Valid ---</option>
                                <option value="1" @if (old('valid',$statute->valid) == "1") {{ 'selected' }} @endif>Yes</option>
                                <option value="0" @if (old('valid',$statute->valid) == "0") {{ 'selected' }} @endif>No</option>
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