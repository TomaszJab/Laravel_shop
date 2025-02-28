@extends('products.layout')
@section('content')
@if ($errors->any())
    <div class="alert alert-danger">
        @foreach ($errors->all() as $error)
            {{ $error }}
        @endforeach
    </div>
@endif

<div class="row">
    <div class="col-md-12 col-sm-12 mt-4 mb-4 p-4 bg-primary text-white rounded">
        <h1>Summary</h1>
    </div>
</div>

<div class="row mb-4">
    <div class="col-lg-8">
        @include('cart.components.cart-item',['enableButtons' => false])
        <br/>
        <div class="row botton">
            <div class="col-12 col-md-12 text-end">
                <!-- Edit Cart Button -->
                @if($enableButtons ?? true)
                    <a href="{{ route('carts.index') }}" class="btn btn-outline-primary">Edit Cart</a>
                @endif
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <!-- Cart Summary -->
        <div class="card cart-summary" style="background-color: #f8f9fa;">
            <div class="card-body">
                @include('cart.components.orderSummary')
                @if($enableButtons ?? true)
                    <a href="{{ route('carts.delivery') }}" class="btn btn-outline-primary w-100">Edit delivery and payment</a>
                @endif
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-12 mb-4">
            <div class="card">
                <form action="{{ route('carts.savewithoutregistration') }}" method="POST">
                @csrf
                    <div class="card-body">
                        <div class="row">
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                <h6 class="mb-2 mt-1 text-primary">Personal Details</h6>
                            </div>
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                <div class="form-group">
                                    <label for="Email" class="mb-1">Email<span class="text-danger"> *</span></label>
                                    <input type="email" value="{{$summary['email']}}" class="form-control mb-2" name="email" id="email" placeholder="Enter email" disabled>
                                </div>
                            </div>
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                <div class="form-group">
                                    <label for="firstName" class="mb-1">First name<span class="text-danger"> *</span></label>
                                    <input type="text" value="{{$summary['firstName']}}" class="form-control mb-2" name="firstName" id="firstName" placeholder="Enter first name" disabled>
                                </div>
                            </div>
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                <div class="form-group">
                                    <label for="lastName" class="mb-1">Last name<span class="text-danger"> *</span></label>
                                    <input type="text" class="form-control" value="{{$summary['lastName']}}" name="lastName" id="lastName" placeholder="Enter last name" disabled>
                                </div>
                            </div>
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                <div class="form-group">
                                    <label for="phone" class="mb-1">Phone<span class="text-danger"> *</span></label>
                                    <input type="text" class="form-control"  value="{{$summary['phone']}}" name="phone" id="phone" placeholder="Enter phone" disabled>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                <h6 class="mt-3 mb-1 text-primary">Address</h6>
                            </div>
                        </div>

                        <div class="btn-group mb-1 mt-1" role="group">
                            <input type="radio" class="btn-check" name="company_or_private_person" value="private_person" id="private_person" autocomplete="off" {{ $summary['company_or_private_person'] == 'private_person' ? 'checked' : '' }} checked disabled>
                            <label class="btn btn-primary" style="width: 130px;" for="private_person" onclick="showContent('private person')">Private person</label>

                            <input type="radio" class="btn-check" name="company_or_private_person" value="company" id="company" autocomplete="off" {{ $summary['company_or_private_person'] == 'company' ? 'checked' : '' }} disabled>
                            <label class="btn btn-primary" style="width: 130px;" for="company" onclick="showContent('company_section')" >Company</label>
                        </div>

                        <div id="company_section" class="content-section" style={{ $summary['company_or_private_person'] == 'company' ? "display: none;" : "" }}>
                            <div class="row">
                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                    <div class="form-group">
                                        <label for="company name" class="mb-1 mt-1">Company name<span class="text-danger"> *</span></label>
                                        <input type="name" class="form-control mb-2" value="{{ $summary['company_name'] }}" name="company name" id="company name" placeholder="Enter Company name" disabled>
                                    </div>
                                </div>
                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                    <div class="form-group">
                                        <label for="nip" class="mb-1 mt-1">Nip<span class="text-danger"> *</span></label>
                                        <input type="name" class="form-control mb-2" value="{{ $summary['nip'] }}" name="nip" id="nip" placeholder="Enter Nip" disabled>
                                    </div>
                                </div>
                            </div>                           
                        </div>

                        <!-- <div id="private person" class="content-section"> -->
                            <div class="row">
                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                    <div class="form-group">
                                        <label for="street" class="mb-1 mt-1">Street<span class="text-danger"> *</span></label>
                                        <input type="name" value="{{$summary['street']}}" name="street" class="form-control mb-2" id="street" placeholder="Enter Street" disabled>
                                    </div>
                                </div>
                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                    <div class="form-group">
                                        <label for="house_number" class="mb-1 mt-1">House number<span class="text-danger"> *</span></label>
                                        <input type="text" value="{{$summary['house_number']}}" name='house_number' class="form-control" id="house_number" placeholder="Enter house number" disabled>
                                    </div>
                                </div>
                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                    <div class="form-group">
                                        <label for="zip_code" class="mb-1">Zip Code<span class="text-danger"> *</span></label>
                                        <input type="text" value="{{$summary['zip_code']}}" name="zip_code" class="form-control" id="zip_code" placeholder="Zip Code" disabled>
                                    </div>
                                </div>
                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                    <div class="form-group">
                                        <label for="city" class="mb-1">City<span class="text-danger"> *</span></label>
                                        <input type="name" value="{{$summary['city']}}" name="city" class="form-control mb-2" id="city" placeholder="Enter City" disabled>
                                    </div>
                                </div>
                            </div>
                        <!-- </div> -->

                        <div class="row">
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                <h6 class="mt-3 mb-3 text-primary">Additional information</h6>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                <!-- <label for="additional_information">Example textarea</label> -->
                                <textarea class="form-control mb-2" name="additional_information" id="additional_information" rows="2" placeholder="You can write something of your own" disabled>{{ $summary['additional_information'] }}</textarea>
                            </div>
                        </div>
                        @if($enableButtons ?? true)
                        <div class="row">
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                <div class="form-check">
                                    <input class="form-check-input" @if($summary['acceptance_of_the_regulations']) checked @endif name="acceptance_of_the_regulations" type="checkbox" id="acceptance_of_the_regulations" disabled>
                                    <label class="form-check-label" for="acceptance_of_the_regulations">I have read the <a href="/statutes" target="_blank">regulations</a> of the online store and accept their content.<span class="text-danger"> *</span></label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                <div class="form-check">
                                    <input class="form-check-input" @if($summary['acceptance_of_the_invoice'] ?? false) checked @endif name="acceptance_of_the_invoice" type="checkbox" id="acceptance_of_the_invoice" disabled>
                                    <label class="form-check-label" for="acceptance_of_the_invoice">I want to receive an invoice</label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                <div class="text-end">
                                    <button type="submit" id="submit" name="submit" class="btn btn-primary mt-3">Summary</button>
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>
                </form>
            </div>
    </div>
</div>

@endsection