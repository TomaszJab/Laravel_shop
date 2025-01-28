@extends('products.layout')
@section('content')

<div class="row">
    <div class="col-lg-4 mb-4 mt-4">
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

    <div class="col-lg-8 mb-4 mt-4">
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
            <h3>Delivery</h3>
            <p>Here you can view delivery options and track your deliveries.</p>
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