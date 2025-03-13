@extends('products.layout')
@section('content')
<div class="container">
<div class="row">
    <div class="col-lg-3 my-5">
        <div class="card" >
        <div class="fakeimg">Fake Image</div>
            <div class="card-body">
                <h5 class="card-title">Card title</h5>
                <p class="card-text">View completed orders and keep track of new ones. Change your details, addresses and notification preferences.</p>
            </div>
            <ul class="list-group list-group-flush">
                <li class="list-group-item active" onclick="showContent('orders', this)">Orders</li>
                @if(auth()->user()->isAdmin())
                <li class="list-group-item" onclick="showContent('products', this)">Products</li>
                @endif
                <li class="list-group-item" onclick="showContent('delivery', this)">Delivery</li>
                <li class="list-group-item" onclick="showContent('account', this)">Account settings</li>
            </ul>
        </div>
    </div>

    <div class="col-lg-9 my-5">
        @if($OrderProducts->isNotEmpty())
        <div id="orders" class="content-section">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title text-primary">Orders</h5>
                
                    <div class="table-responsive-xl">
                        <table class="table-responsive-xl table table-hover table-striped">
                            <thead>
                                <tr>
                                    <th scope="col">id</th>
                                    <th scope="col">wartość</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Promo code</th>
                                    <th scope="col">Delivery</th>
                                    <th scope="col">Payment</th>
                                    <th scope="col">Created at</th>
                                    <th scope="col">created at</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($OrderProducts as $OrderProduct)
                                    <tr>
                                        <th scope="row">{{ $OrderProduct -> personal_details_id }}</th>
                                        <td>{{ $OrderProduct -> method_delivery }}</td>
                                        <td>{{ $OrderProduct -> method_payment }}</td>
                                        <td>{{ $OrderProduct -> promo_code ?? 'brak' }}</td>
                                        <td>{{ $OrderProduct -> delivery }}$</td>
                                        <td>{{ $OrderProduct -> payment }}$</td>
                                        <td>{{ $OrderProduct -> created_at }}</td> 
                                        <td>
                                            <a class="btn btn-primary" href="{{ route('carts.order.details', $OrderProduct -> id) }}">Show</a>
                                        </td> 
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="col-md-2 ms-auto d-flex justify-content-end fs-4 mt-4 pagination">
                            {!! $OrderProducts->links() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @else
        <div id="orders" class="content-section">
            <div class="card">
                <div class="card-header mt-2">
                    <h5>Orders</h5>
                </div>
                <div class="card-body cart text-center">
                <i class="bi bi-box mb-4 mr-3" style="font-size:80px;color: orange;"></i>
                    <h3 class="my-2"><strong>You don't have any orders</strong></h3>
                    <h4 class="my-2">Order something to make your day better</h4>
                    <a href="{{ route('products.index') }}" class="btn btn-outline-primary m-3">
                        <i class="bi bi-arrow-left me-2"></i>Continue Shopping
                    </a>
                </div>
            </div>
        </div>
        @endif
        @if(auth()->user()->isAdmin())
        <div id="products" class="content-section" style="display: none;">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="card-title text-primary">Products</h5>
                        <a class="btn btn-success btn-sm" href="{{ route('products.create') }}"> Create New Product</a>
                    </div>
                    <div class="table-responsive-xl">
                    <table class="table-responsive-xl table table-hover table-striped">
                            <thead>
                                <tr>
                                    <th scope="col">id</th>
                                    <th scope="col">wartość</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Promo code</th>
                                    <th scope="col">Delivery</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($products as $product)
                                    <tr>
                                        <th scope="row"></th>
                                        <td>{{ $product->name }}</td>
                                        <td>{{ $product->price }}</td>
                                        <td>{{ $product->detail }}</td>
                                        <td>
                                            <form action="{{ route('products.destroy', $product -> id) }}" method="POST">
                                                <a class="btn btn-info btn-sm" href="{{ route('products.show', $product -> id) }}">Show</a>
                                                <a class="btn btn-primary btn-sm" href="{{ route('products.edit', $product -> id) }}">Edit</a>
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="col-md-2 ms-auto d-flex justify-content-end fs-4 mt-4 pagination">
                            {!! $products->links() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif
        <div id="delivery" class="content-section" style="display: none;">
                <div class="card">
                    <div class="card-body">
                    <form action="{{ route('carts.updateDefaultPersonalDetails') }}" method="POST">
                    @csrf
                        <div class="row">
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                <h6 class="mb-2 mt-1 text-primary">Default Personal Details</h6>
                            </div>
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                <div class="form-group">
                                    <label for="email" class="mb-1">Email</label>
                                    <input type="email" name="email" value="{{ $personalDetails->email ?? '' }}"  class="form-control mb-2" id="email" placeholder="Enter email">
                                </div>
                            </div>
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                <div class="form-group">
                                    <label for="firstName" class="mb-1">First name</label>
                                    <input type="text" name="firstName" value="{{ $personalDetails->firstName ?? '' }}" class="form-control mb-2" id="firstName" placeholder="Enter first name">
                                </div>
                            </div>
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                <div class="form-group">
                                    <label for="lastName" class="mb-1">Last name</label>
                                    <input type="text" name="lastName" value="{{ $personalDetails->lastName ?? '' }}" class="form-control" id="lastName" placeholder="Enter last name">
                                </div>
                            </div>
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                <div class="form-group">
                                    <label for="phone" class="mb-1">Phone</label>
                                    <input type="text" name="phone" value="{{ $personalDetails->phone ?? '' }}" class="form-control" id="phone" placeholder="Enter phone">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                <h6 class="mt-3 mb-1 text-primary">Default Address</h6>
                            </div>

                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                <div class="btn-group mb-1 mt-1" role="group">
                                    <input type="radio" class="btn-check" name="company_or_private_person" value="private_person" id="private_person" autocomplete="off" {{ $personalDetails->company_or_private_person == 'private_person' ? 'checked' : '' }} checked>
                                    <label class="btn btn-primary" for="private_person" onclick="showContent1('private person')">Private person</label>

                                    <input type="radio" class="btn-check" name="company_or_private_person" value="company" id="company" autocomplete="off" {{ $personalDetails->company_or_private_person == 'company' ? 'checked' : '' }}>
                                    <label class="btn btn-primary" for="company" onclick="showContent1('company_section')" >Company</label>
                                </div>
                            </div>

                            <div id="company_section" class="content-section_2" @if($personalDetails->company_or_private_person == 'company') style="display: block;" @else style="display: none;" @endif>
                                <div class="row">
                                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label for="company_name" class="mb-1 mt-1">Company name<span class="text-danger"> *</span></label>
                                            <input type="text" class="form-control mb-2" value="{{ $personalDetails->company_name ?? '' }}" name="company_name" id="company name" placeholder="Enter Company name">
                                        </div>
                                    </div>
                                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label for="nip" class="mb-1 mt-1">Nip<span class="text-danger"> *</span></label>
                                            <input type="number" class="form-control mb-2" value="{{ $personalDetails->nip ?? '' }}" name="nip" id="nip" placeholder="Enter Nip">
                                        </div>
                                    </div>
                                </div>                           
                            </div>
                            
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                <div class="form-group">
                                    <label for="street" class="mb-1 mt-1">Street</label>
                                    <input type="text" name="street" class="form-control mb-2" value="{{ $personalDetails->street ?? '' }}" id="Street" placeholder="Enter Street">
                                </div>
                            </div>
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                <div class="form-group">
                                    <label for="house_number" class="mb-1 mt-1">House number</label>
                                    <input type="text" name="house_number" class="form-control" value="{{ $personalDetails->house_number ?? '' }}" id="house number" placeholder="Enter house number">
                                </div>
                            </div>
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                <div class="form-group">
                                    <label for="zip_code" class="mb-1">Zip Code</label>
                                    <input type="text" name="zip_code"  class="form-control" value="{{ $personalDetails->zip_code ?? '' }}" id="zip_code" placeholder="Zip Code">
                                </div>
                            </div>
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                <div class="form-group">
                                    <label for="city" class="mb-1">City</label>
                                    <input type="text" name="city"  class="form-control mb-2" value="{{ $personalDetails->city ?? '' }}" id="City" placeholder="Enter City">
                                </div>
                            </div>
                            <div class="row pt-2">
                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                    <div class="form-check">
                                        <input class="form-check-input" @if($personalDetails->acceptance_of_the_regulations=='on') checked @endif name="acceptance_of_the_regulations" type="checkbox" id="acceptance_of_the_regulations">
                                        <label class="form-check-label" for="acceptance_of_the_regulations">I have read the <a href="/statutes" target="_blank">regulations</a> of the online store and accept their content.<span class="text-danger"> *</span></label>
                                    </div>
                                </div>
                            </div>
                            <div class="row pt-2">
                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                    <div class="form-check">
                                        <input class="form-check-input" @if($personalDetails->acceptance_of_the_invoice ?? false) checked @endif name="acceptance_of_the_invoice" type="checkbox" id="acceptance_of_the_invoice">
                                        <label class="form-check-label" for="acceptance_of_the_invoice">I want to receive an invoice</label>
                                    </div>
                                </div>
                            </div>

                            <input type="hidden" name="default_personal_details" value="1">

                        </div>
                        <div class="row">
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                <div class="text-end">
                                    <button type="submit" id="submit" name="submit" class="btn btn-primary mt-3">Update</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    </form>
                </div>
                <div class="card mt-4">
                    <div class="card-body">
                    <form action="{{ route('carts.updateDefaultPersonalDetails') }}" method="POST">
                    @csrf
                        <div class="row">
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                <h6 class="mb-2 mt-1 text-primary">Additional Personal Details</h6>
                            </div>
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                <div class="form-group">
                                    <label for="email" class="mb-1">Email</label>
                                    <input type="email" name="email" value="{{ $additionalPersonalDetails->email ?? '' }}" class="form-control mb-2" id="email" placeholder="Enter email">
                                </div>
                            </div>
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                <div class="form-group">
                                    <label for="firstName" class="mb-1">First name</label>
                                    <input type="text" name="firstName" value="{{ $additionalPersonalDetails->firstName ?? '' }}" class="form-control mb-2" id="firstName" placeholder="Enter first name">
                                </div>
                            </div>
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                <div class="form-group">
                                    <label for="lastName" class="mb-1">Last name</label>
                                    <input type="text" name="lastName" value="{{ $additionalPersonalDetails->lastName ?? '' }}" class="form-control" id="lastName" placeholder="Enter last name">
                                </div>
                            </div>
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                <div class="form-group">
                                    <label for="phone" class="mb-1">Phone</label>
                                    <input type="text" name="phone" value="{{ $additionalPersonalDetails->phone ?? '' }}" class="form-control" id="phone" placeholder="Enter phone">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                <h6 class="mt-3 mb-1 text-primary">Additional Address</h6>
                            </div>
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                <div class="form-group">
                                    <label for="street" class="mb-1 mt-1">Street</label>
                                    <input type="text" name="street" value="{{ $additionalPersonalDetails->street ?? '' }}" class="form-control mb-2" id="Street" placeholder="Enter Street">
                                </div>
                            </div>
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                <div class="form-group">
                                    <label for="house_number" class="mb-1 mt-1">House number</label>
                                    <input type="text" name="house_number" value="{{ $additionalPersonalDetails->house_number ?? '' }}" class="form-control" id="house_number" placeholder="Enter house number">
                                </div>
                            </div>
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                <div class="form-group">
                                    <label for="zip_code" class="mb-1">Zip Code</label>
                                    <input type="text" name="zip_code" value="{{ $additionalPersonalDetails->zip_code ?? '' }}" class="form-control" id="zip code" placeholder="Zip Code">
                                </div>
                            </div>
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                <div class="form-group">
                                    <label for="city" class="mb-1">City</label>
                                    <input type="text" name="city" value="{{ $additionalPersonalDetails->city ?? '' }}" class="form-control mb-2" id="ciTy" placeholder="Enter City">
                                </div>
                            </div>
                            
                            <input type="hidden" name="default_personal_details" value="0">

                        </div>
                        <div class="row">
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                <div class="text-end">
                                    <button type="submit" id="submit" name="submit" class="btn btn-primary mt-3">Update</button>
                                </div>
                            </div>
                        </div>
                        </form>
                    </div>
                </div>
        </div>

        <div id="account" class="content-section" style="display: none;">
            <div class="card">
                <div class="card-body">
                    <h5 class="text-primary">Account Settings</h5>
                    <p>Here you can manage your account settings.</p>
                </div>
            </div>
        </div>
    </div>
</div>
</div>

<script>
        // JavaScript to handle switching views
    function showContent1(sectionId) {
        // Hide all sections
        document.querySelectorAll('.content-section_2').forEach(function (section) {
            section.style.display = 'none';
        });

        // Show the selected section
        document.getElementById(sectionId).style.display = 'block';
    }

    jQuery(function($){
    $("input#zip").mask("00-000");
    });
    // JavaScript to handle switching views
    function showContent(sectionId,element) {
        // Hide all sections
        document.querySelectorAll('.content-section').forEach(function (section) {
            section.style.display = 'none';
        });

        // Remove the 'active' class from all list items
        document.querySelectorAll('.list-group-item').forEach(function (item) {
            item.classList.remove('active');
        });

        // Show the selected section
        document.getElementById(sectionId).style.display = 'block';

        element.classList.add('active');
    }
</script>
@endsection