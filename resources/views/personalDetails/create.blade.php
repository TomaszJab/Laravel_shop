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
@php
    $summary = session('personalDetails', []);
@endphp
<div class="row">
    <div class="col-lg-12 mb-4 mt-4">
            <div class="card">
                <form action="{{ route('personalDetails.walidate') }}" method="POST">
                @csrf
                    <div class="card-body">
                        <div class="row">
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                <h6 class="mb-2 mt-1 text-primary">Personal Details</h6>
                            </div>
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                <div class="form-group">
                                    <label for="email" class="mb-1">Email<span class="text-danger"> *</span></label>
                                    <input type="email" value="{{ old('email') ?? optional($defaultPersonalDetails)->email }}" class="form-control mb-2" name="email" id="email" placeholder="Enter email">
                                </div>
                            </div>
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                <div class="form-group">
                                    <label for="firstName" class="mb-1">First name<span class="text-danger"> *</span></label>
                                    <input type="text" value="{{ old('firstName') ?? optional($defaultPersonalDetails)->firstName }}" class="form-control mb-2" name="firstName" id="firstName" placeholder="Enter first name">
                                </div>
                            </div>
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                <div class="form-group">
                                    <label for="lastName" class="mb-1">Last name<span class="text-danger"> *</span></label>
                                    <input type="text" class="form-control" value="{{ old('lastName') ?? optional($defaultPersonalDetails)->lastName }}" name="lastName" id="lastName" placeholder="Enter last name">
                                </div>
                            </div>
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                <div class="form-group">
                                    <label for="phone" class="mb-1">Phone<span class="text-danger"> *</span></label>
                                    <input type="phone" class="form-control"  value="{{ old('phone') ?? optional($defaultPersonalDetails)->phone }}" name="phone" id="phone" placeholder="Enter phone">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                <h6 class="mt-3 mb-1 text-primary">Address</h6>
                            </div>
                        </div>

                        <div class="btn-group mb-1 mt-1" role="group">
                            <input type="radio" class="btn-check" name="company_or_private_person" value="private_person" id="private_person" autocomplete="off" {{ old('company_or_private_person') ?? optional($defaultPersonalDetails)->company_or_private_person == 'private_person' ? 'checked' : '' }} checked>
                            <label class="btn btn-primary" style="width: 130px;" for="private_person" onclick="showContent('private person')">Private person</label>

                            <input type="radio" class="btn-check" name="company_or_private_person" value="company" id="company" autocomplete="off" {{ old('company_or_private_person') ?? optional($defaultPersonalDetails)->company_or_private_person == 'company' ? 'checked' : '' }}>
                            <label class="btn btn-primary" style="width: 130px;" for="company" onclick="showContent('company_section')" >Company</label>
                        </div>

                        <div id="company_section" class="content-section" style="display: none;">
                            <div class="row">
                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                    <div class="form-group">
                                        <label for="company_name" class="mb-1 mt-1">Company name<span class="text-danger"> *</span></label>
                                        <input type="text" class="form-control mb-2" value="{{ old('company name') ?? optional($defaultPersonalDetails)->company_name }}" name="company_name" id="company name" placeholder="Enter Company name">
                                    </div>
                                </div>
                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                    <div class="form-group">
                                        <label for="nip" class="mb-1 mt-1">Nip<span class="text-danger"> *</span></label>
                                        <input type="number" class="form-control mb-2" value="{{ old('nip') ?? optional($defaultPersonalDetails)->nip }}" name="nip" id="nip" placeholder="Enter Nip">
                                    </div>
                                </div>
                            </div>                           
                        </div>

                        <!-- <div id="private person" class="content-section"> -->
                            <div class="row">
                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                    <div class="form-group">
                                        <label for="street" class="mb-1 mt-1">Street<span class="text-danger"> *</span></label>
                                        <input type="text" value="{{ old('street') ?? optional($defaultPersonalDetails)->street }}" name="street" class="form-control mb-2" id="street" placeholder="Enter Street">
                                    </div>
                                </div>
                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                    <div class="form-group">
                                        <label for="house_number" class="mb-1 mt-1">House number<span class="text-danger"> *</span></label>
                                        <input type="text" value="{{ old('house_number') ?? optional($defaultPersonalDetails)->house_number }}" name='house_number' class="form-control" id="house_number" placeholder="Enter house number">
                                    </div>
                                </div>
                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                    <div class="form-group">
                                        <label for="zip_code" class="mb-1">Zip Code<span class="text-danger"> *</span></label>
                                        <input type="text" value="{{ old('zip_code') ?? optional($defaultPersonalDetails)->zip_code }}" name="zip_code" class="form-control" id="zip_code" placeholder="Zip Code">
                                    </div>
                                </div>
                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                    <div class="form-group">
                                        <label for="city" class="mb-1">City<span class="text-danger"> *</span></label>
                                        <input type="text" value="{{ old('city') ?? optional($defaultPersonalDetails)->city }}" name="city" class="form-control mb-2" id="city" placeholder="Enter City">
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
                                <textarea class="form-control mb-2" name="additional_information" id="additional_information" rows="2" placeholder="You can write something of your own">{{ old('additional_information') }}</textarea>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                <div class="form-check">
                                    <input class="form-check-input" @if(old('acceptance_of_the_regulations')) checked @endif name="acceptance_of_the_regulations" type="checkbox" id="acceptance_of_the_regulations">
                                    <label class="form-check-label" for="acceptance_of_the_regulations">I have read the <a href="/statutes" target="_blank">regulations</a> of the online store and accept their content.<span class="text-danger"> *</span></label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                <div class="form-check">
                                    <input class="form-check-input" @if(old('acceptance_of_the_invoice')) checked @endif name="acceptance_of_the_invoice" type="checkbox" id="acceptance_of_the_invoice">
                                    <label class="form-check-label" for="acceptance_of_the_invoice">I want to receive an invoice</label>
                                </div>
                            </div>
                        </div>
                        <!-- <label for="zip">Zip Code</label>
                        <input id="zip" type="number" name="zip" placeholder="Zip Code"> -->
                        
                        <div class="row">
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                <div class="text-end">
                                    <button type="submit" id="submit" name="submit" class="btn btn-primary mt-3">Summary</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
    </div>
</div>
</div>
<script>
    // JavaScript to handle switching views
    function showContent(sectionId) {
        // Hide all sections
        document.querySelectorAll('.content-section').forEach(function (section) {
            section.style.display = 'none';
        });

        // Show the selected section
        document.getElementById(sectionId).style.display = 'block';
    }

    jQuery(function($){
   $("input#zip").mask("00-000");
});
</script>
@endsection