@extends('products.layout')
@section('content')

<div class="row">
    <div class="col-lg-12 mb-4 mt-4">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                <h6 class="mb-2 mt-1 text-primary">Personal Details</h6>
                            </div>
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                <div class="form-group">
                                    <label for="Email" class="mb-1">Email<span class="text-danger"> *</span></label>
                                    <input type="email" class="form-control mb-2" id="email" placeholder="Enter email">
                                </div>
                            </div>
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                <div class="form-group">
                                    <label for="firstName" class="mb-1">First name<span class="text-danger"> *</span></label>
                                    <input type="text" class="form-control mb-2" id="firstName" placeholder="Enter first name">
                                </div>
                            </div>
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                <div class="form-group">
                                    <label for="lastName" class="mb-1">Last name<span class="text-danger"> *</span></label>
                                    <input type="text" class="form-control" id="lastName" placeholder="Enter last name">
                                </div>
                            </div>
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                <div class="form-group">
                                    <label for="phone" class="mb-1">Phone<span class="text-danger"> *</span></label>
                                    <input type="text" class="form-control" id="phone" placeholder="Enter phone">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                <h6 class="mt-3 mb-1 text-primary">Address</h6>
                            </div>
                        </div>

                        <div class="btn-group mb-1 mt-1" role="group">
                            <input type="radio" class="btn-check" name="options" id="option1" autocomplete="off" checked>
                            <label class="btn btn-primary" style="width: 130px;" for="option1">Private person</label>

                            <input type="radio" class="btn-check" name="options" id="option2" autocomplete="off">
                            <label class="btn btn-primary" style="width: 130px;" for="option2">Company</label>
                        </div>

                        <div class="row">
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                <div class="form-group">
                                    <label for="Street" class="mb-1 mt-1">Street<span class="text-danger"> *</span></label>
                                    <input type="name" class="form-control mb-2" id="Street" placeholder="Enter Street">
                                </div>
                            </div>
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                <div class="form-group">
                                    <label for="house number" class="mb-1 mt-1">House number<span class="text-danger"> *</span></label>
                                    <input type="text" class="form-control" id="house number" placeholder="Enter house number">
                                </div>
                            </div>
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                <div class="form-group">
                                    <label for="zip code" class="mb-1">Zip Code<span class="text-danger"> *</span></label>
                                    <input type="text" class="form-control" id="zip code" placeholder="Zip Code">
                                </div>
                            </div>
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                <div class="form-group">
                                    <label for="City" class="mb-1">City<span class="text-danger"> *</span></label>
                                    <input type="name" class="form-control mb-2" id="ciTy" placeholder="Enter City">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                <div class="form-group">
                                    <label for="Company name" class="mb-1 mt-1">Company name<span class="text-danger"> *</span></label>
                                    <input type="name" class="form-control mb-2" id="Company name" placeholder="Enter Company name">
                                </div>
                            </div>
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                <div class="form-group">
                                    <label for="Nip" class="mb-1 mt-1">Nip<span class="text-danger"> *</span></label>
                                    <input type="name" class="form-control mb-2" id="Nip" placeholder="Enter Nip">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                <div class="form-group">
                                    <label for="Street" class="mb-1 mt-1">Street<span class="text-danger"> *</span></label>
                                    <input type="name" class="form-control mb-2" id="Street" placeholder="Enter Street">
                                </div>
                            </div>
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                <div class="form-group">
                                    <label for="house number" class="mb-1 mt-1">House number<span class="text-danger"> *</span></label>
                                    <input type="text" class="form-control" id="house number" placeholder="Enter house number">
                                </div>
                            </div>
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                <div class="form-group">
                                    <label for="zip code" class="mb-1">Zip Code<span class="text-danger"> *</span></label>
                                    <input type="text" class="form-control" id="zip code" placeholder="Zip Code">
                                </div>
                            </div>
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                <div class="form-group">
                                    <label for="City" class="mb-1">City<span class="text-danger"> *</span></label>
                                    <input type="name" class="form-control mb-2" id="ciTy" placeholder="Enter City">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                <h6 class="mt-3 mb-3 text-primary">Additional information</h6>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                <!-- <label for="exampleFormControlTextarea1">Example textarea</label> -->
                                <textarea class="form-control mb-2" id="exampleFormControlTextarea1" rows="2" placeholder="You can write something of your own"></textarea>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="gridCheck">
                                    <label class="form-check-label" for="gridCheck">I have read the <a href="/statutes" target="_blank">regulations</a> of the online store and accept their content.<span class="text-danger"> *</span></label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="gridCheck">
                                    <label class="form-check-label" for="gridCheck">I want to receive an invoice</label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                <div class="text-end">
                                    <button type="button" id="submit" name="submit" class="btn btn-primary mt-3">Send</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
    </div>
</div>


@endsection