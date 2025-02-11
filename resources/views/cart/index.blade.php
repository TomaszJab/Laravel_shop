@extends('products.layout')
@section('content')
<div class="row">
    <div class="col-md-12 col-sm-12 mt-4 mb-4 p-4 bg-primary text-white rounded">
        <h1>Your cart</h1>
    </div>
</div>

@if ($message = Session::get('success'))
    <div class="alert alert-success">
        <p>{{ $message }}</p>
    </div>
@endif

@if(session('cart'))

@php
    $cart = session('cart');
    $products = array_filter($cart, 'is_array'); // Pobierz tylko produkty
    $subtotal = collect($products)->sum(fn($item) => $item['price'] * $item['quantity']);
    $shipping = $cart['delivery'];
    $payment = $cart['payment'];
    $total = $subtotal + $shipping + $payment;
@endphp

<div class="row">
    <div class="col-lg-8 mb-4">
        <div class="card" style="top: 0;">
            <div class="card-body">
                @foreach($products as $id => $details)
                @if(!$loop->first)
                    <hr>
                @endif
                <div class="row cart-item mb-0">
                    <div class="col-md-3">
                        <div class="fakeimg img-fluid rounded p-2" style="max-height: 100px; max-width: 180px">Fake Image</div>
                    </div>
                    <div class="col-md-5">
                        <h5 class="card-title">{{ $details['name'] }}</h5>
                        <p class="text-muted">Category: {{ $details['name_category_product'] }}</p>
                    </div>
                    <div class="col-md-2">
                        <div class="input-group">
                            <button class="btn btn-outline-secondary btn-sm quantity-btn decrease" data-action="decrease" data-product-id="{{ $id }}">-</button>
                            <input type="text" class="form-control form-control-sm text-center quantity-input" style="max-width:100px" value="{{ $details['quantity'] }}" readonly>
                            <button class="btn btn-outline-secondary btn-sm quantity-btn increase" data-action="increase" data-product-id="{{ $id }}">+</button>
                        </div>
                        <!-- <div id="response-message"></div> -->
                    </div>
                    <div class="col-md-2 text-end">
                        <p class="fw-bold">${{ number_format($details['price'] * $details['quantity'], 2) }}</p>
                        <form action="{{ route('carts.destroy',$id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                        </form>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        <br/>
        <div class="row botton">
            <div class="col-6 col-md-6 text-start">
                <!-- Continue Shopping Button -->
                <a href="{{ route('products.index') }}" class="btn btn-outline-primary">
                    <i class="bi bi-arrow-left me-2"></i>Continue Shopping
                </a>
            </div>
            <div class="col-6 col-md-6 text-end">
                <!-- Continue Shopping Button -->
                <form action="{{ route('carts.clear') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-outline-warning">Clear Cart</button>
                </form>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <!-- Cart Summary -->
        <div class="card cart-summary" style="background-color: #f8f9fa;">
            <div class="card-body">
                <h5 class="card-title mb-4">Order Summary</h5>
                <div class="d-flex justify-content-between mb-3">
                    <span>Subtotal</span>
                    <span id="subtotalValue">${{$subtotal}}</span>
                </div>
                <div class="d-flex justify-content-between mb-3">
                    <span>Shipping</span>
                    <span id="shippingValue">${{$shipping}}</span>
                </div>
                <div class="d-flex justify-content-between mb-3">
                    <span>Payment</span>
                    <span id="paymentValue">${{$payment}}</span>
                </div>
                @if (!empty($cart['promo_code']))
                <div class="discount" id="discount" style="display: inline;">
                @else
                <div class="discount" id="discount" style="display: none;">
                @endif
                    <div class="d-flex justify-content-between mb-3">
                        <span>Discount</span>
                        <span id="discountValue">{{$cart['promo_code']}}%</span>
                    </div> 
                </div>
                              
                <hr>
                <div class="d-flex justify-content-between mb-4">
                    <strong>Total</strong>
                @if ($cart['promo_code']<>'')
                    <strong id="totalValue">${{$total - ($total * $cart['promo_code'])/100}}</strong>
                @else
                    <strong id="totalValue">${{$total}}</strong>
                @endif
                </div>
                <a href="{{ route('carts.delivery') }}" class="btn btn-primary w-100">Delivery and payment</a>
            </div>
        </div>
        <!-- Promo Code -->
        <div class="card mt-4">
            <div class="card-body">
            <form id="promo-form">
                <h5 class="card-title mb-3">Apply Promo Code</h5>
                <div class="input-group mb-3">
                @csrf
                    <input type="text" id="promo_code" class="form-control" placeholder="Enter promo code">
                    <button class="btn btn-outline-secondary apply-promo" type="submit">Apply</button>
                </div>
            </div>
            </form>
        </div>
            <!-- Feedback message -->
        <div id="response-message" class="mt-3"></div>
    </div>
</div>
@else
<div class="row">	 
    <div class="col-md-12 col-sm-12"> 
        <div class="card">
            <div class="card-header">
                <h5>Cart</h5>
            </div>
            <div class="card-body cart text-center">
            <i class="bi bi-cart3 mb-4 mr-3" style="font-size:80px;color: orange;"></i>
                <h3><strong>Your Cart is Empty</strong></h3>
                <h4>Add something to make me happy :)</h4>
                <a href="{{ route('products.index') }}" class="btn btn-outline-primary m-3">
                    <i class="bi bi-arrow-left me-2"></i>Continue Shopping
                </a>
            </div>
        </div>
    </div>
</div>
@endif       

<script>
        $(document).ready(function() {
        $(".quantity-btn").click(function() {
            let action = $(this).data("action");
            let productId = $(this).data("product-id");
            let quantityInput = $(this).siblings(".quantity-input");

            $.ajax({
                url: "{{ route('carts.changequantity') }}",
                type: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    action: action,
                    product_id: productId
                },
                success: function(response) {
                    if (response.success) {
                        quantityInput.val(response.new_quantity);
                    } else {
                        $("#response-message").html('<div class="alert alert-danger">' + response.message + '</div>');
                    }
                },
                error: function(xhr, status, error) {
                    $("#response-message").html('<div class="alert alert-danger">Błąd: ' + xhr.responseText + '</div>');
                }
            });
        });
    });

    $(document).ready(function() {
        // Event listener for form submission
        $("#promo-form").on('submit', function(e) {
            e.preventDefault(); // Prevent the default form submission

            // Get form data
            let promoCode = $("#promo_code").val();
            //let validFrom = $("#valid_from").val();
            //let validUntil = $("#valid_until").val();

            // Send the form data via AJAX to the route
            $.ajax({
                url: '/carts/add-promo', // Route for adding the promo code
                type: 'POST',
                data: {
                    _token: "{{ csrf_token() }}", // CSRF token for security
                    promo_code: promoCode//,
                    //valid_from: validFrom,
                    //valid_until: validUntil
                },
                success: function(response) {
                    // Show a success or failure message depending on the response
                    if (response.success) {
                        $("#response-message").html('<div class="alert alert-success">Promo code added successfully!</div>');
                        $("#promo-form")[0].reset(); // Clear the form fields
                        document.getElementById("discount").style.display = "inline";
                        $('#discountValue').text(response.discount + "%");
                        let promoCode = $("#promo_code").val();

                        let subtotalValue = document.getElementById("subtotalValue").innerHTML;
                        let shippingValue = document.getElementById("shippingValue").innerHTML;
                        let paymentValue = document.getElementById("paymentValue").innerHTML;

                        subtotalValue = parseFloat(subtotalValue.replace("$", ""));
                        shippingValue = parseFloat(shippingValue.replace("$", ""));
                        paymentValue = parseFloat(paymentValue.replace("$", ""));
                        let totalValue = subtotalValue + shippingValue + paymentValue;
                        totalValue = totalValue - (totalValue/response.discount)
                        $('#totalValue').text('$' + totalValue);
                        console.log("Subtotal Value:", totalValue);
                    } else {
                        $("#response-message").html('<div class="alert alert-danger">Failed to add promo code. Try again!</div>');
                    }
                },
                error: function(xhr, status, error) {
                    // Handle any error that occurs during the AJAX request
                    $("#response-message").html('<div class="alert alert-danger">An error occurred. Please try again.</div>');
                }
            });
        });
    });
</script>


@endsection