@extends('products.layout')
@section('content')

<div class="row">
    <div class="col-lg-3 mb-4 mt-4">
        <div class="card" >
        <div class="fakeimg">Fake Image</div>
            <div class="card-body">
                <h5 class="card-title">Card title</h5>
                <p class="card-text">View completed orders and keep track of new ones. Change your details, addresses and notification preferences.</p>
            </div>
            <ul class="list-group list-group-flush">
                <li class="list-group-item active" onclick="showContent('orders', this)">Orders</li>
                <li class="list-group-item" onclick="showContent('products', this)">Products</li>
                <li class="list-group-item" onclick="showContent('delivery', this)">Delivery</li>
                <li class="list-group-item" onclick="showContent('account', this)">Account settings</li>
            </ul>
        </div>
    </div>

    <div class="col-lg-9 mb-4 mt-4">
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
                    </div>
                </div>
            </div>
        </div>
        <div id="products" class="content-section" style="display: none;">
        <div class="card">
                <div class="card-body">
                    <h5 class="card-title text-primary">Products</h5>
                
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
                                                <a class="btn btn-info" href="{{ route('products.show', $product -> id) }}">Show</a>
                                                <a class="btn btn-primary" href="{{ route('products.edit', $product -> id) }}">Edit</a>
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger">Delete</button>
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
        <div id="delivery" class="content-section" style="display: none;">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                <h6 class="mb-2 mt-1 text-primary">Default Personal Details</h6>
                            </div>
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                <div class="form-group">
                                    <label for="Email" class="mb-1">Email</label>
                                    <input type="email" class="form-control mb-2" id="email" placeholder="Enter email">
                                </div>
                            </div>
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                <div class="form-group">
                                    <label for="firstName" class="mb-1">First name</label>
                                    <input type="text" class="form-control mb-2" id="firstName" placeholder="Enter first name">
                                </div>
                            </div>
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                <div class="form-group">
                                    <label for="lastName" class="mb-1">Last name</label>
                                    <input type="text" class="form-control" id="lastName" placeholder="Enter last name">
                                </div>
                            </div>
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                <div class="form-group">
                                    <label for="phone" class="mb-1">Phone</label>
                                    <input type="text" class="form-control" id="phone" placeholder="Enter phone">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                <h6 class="mt-3 mb-1 text-primary">Default Address</h6>
                            </div>
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                <div class="form-group">
                                    <label for="Street" class="mb-1 mt-1">Street</label>
                                    <input type="name" class="form-control mb-2" id="Street" placeholder="Enter Street">
                                </div>
                            </div>
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                <div class="form-group">
                                    <label for="house number" class="mb-1 mt-1">House number</label>
                                    <input type="text" class="form-control" id="house number" placeholder="Enter house number">
                                </div>
                            </div>
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                <div class="form-group">
                                    <label for="zip code" class="mb-1">Zip Code</label>
                                    <input type="text" class="form-control" id="zip code" placeholder="Zip Code">
                                </div>
                            </div>
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                <div class="form-group">
                                    <label for="City" class="mb-1">City</label>
                                    <input type="name" class="form-control mb-2" id="City" placeholder="Enter City">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                <div class="text-end">
                                    <button type="button" id="submit" name="submit" class="btn btn-primary mt-3">Update</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card mt-4">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                <h6 class="mb-2 mt-1 text-primary">Additional Personal Details</h6>
                            </div>
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                <div class="form-group">
                                    <label for="Email" class="mb-1">Email</label>
                                    <input type="email" class="form-control mb-2" id="email" placeholder="Enter email">
                                </div>
                            </div>
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                <div class="form-group">
                                    <label for="firstName" class="mb-1">First name</label>
                                    <input type="text" class="form-control mb-2" id="firstName" placeholder="Enter first name">
                                </div>
                            </div>
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                <div class="form-group">
                                    <label for="lastName" class="mb-1">Last name</label>
                                    <input type="text" class="form-control" id="lastName" placeholder="Enter last name">
                                </div>
                            </div>
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                <div class="form-group">
                                    <label for="phone" class="mb-1">Phone</label>
                                    <input type="text" class="form-control" id="phone" placeholder="Enter phone">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                <h6 class="mt-3 mb-1 text-primary">Additional Address</h6>
                            </div>
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                <div class="form-group">
                                    <label for="Street" class="mb-1 mt-1">Street</label>
                                    <input type="name" class="form-control mb-2" id="Street" placeholder="Enter Street">
                                </div>
                            </div>
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                <div class="form-group">
                                    <label for="house number" class="mb-1 mt-1">House number</label>
                                    <input type="text" class="form-control" id="house number" placeholder="Enter house number">
                                </div>
                            </div>
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                <div class="form-group">
                                    <label for="zip code" class="mb-1">Zip Code</label>
                                    <input type="text" class="form-control" id="zip code" placeholder="Zip Code">
                                </div>
                            </div>
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                <div class="form-group">
                                    <label for="City" class="mb-1">City</label>
                                    <input type="name" class="form-control mb-2" id="ciTy" placeholder="Enter City">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                <div class="text-end">
                                    <button type="button" id="submit" name="submit" class="btn btn-primary mt-3">Update</button>
                                </div>
                            </div>
                        </div>
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


<script>
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