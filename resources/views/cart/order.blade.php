@extends('products.layout')
@section('content')

<div class="row">
    <div class="col-lg-3 mb-4 mt-4">
        <div class="card" >
        <div class="fakeimg">Fake Image</div>
            <div class="card-body">
                <h5 class="card-title">Card title</h5>
                <!-- <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p> -->
                <p class="card-text">View completed orders and keep track of new ones. Change your details, addresses and notification preferences.</p>
            </div>
            <ul class="list-group list-group-flush">
                <li class="list-group-item active" onclick="showContent('orders', this)">Orders</li>
                <li class="list-group-item" onclick="showContent('delivery', this)">Delivery</li>
                <li class="list-group-item" onclick="showContent('account', this)">Account settings</li>
            </ul>
        </div>
    </div>

    <div class="col-lg-9 mb-4 mt-4">
        <div id="orders" class="content-section">
            <div class="card">
                <div class="card-body">
                <h5 class="card-title">Delivery</h5>
                    <div class="table-responsive-xl">
                        <table class="table-responsive-xl table table-hover table-striped">
                            <thead>
                                <tr>
                                <th scope="col">numer zamówienia</th>
                                <th scope="col">wartość</th>
                                <th scope="col">status</th>
                                <th scope="col">przesylka</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                <th scope="row">1</th>
                                <td>Mark</td>
                                <td>Otto</td>
                                <td>@mdo</td>
                                </tr>
                                <tr>
                                <th scope="row">2</th>
                                <td>Jacob</td>
                                <td>Thornton</td>
                                <td>@fat</td>
                                </tr>
                                <th scope="row">2</th>
                                <td>Jacob</td>
                                <td>Thornton</td>
                                <td>@fat</td>
                                </tr>
                            </tbody>
                        </table>
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
            <h3>Account Settings</h3>
            <p>Here you can manage your account settings.</p>
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