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
<div class="row">
    <div class="col-lg-8 mb-4">
        <div class="card" style="top: 0;">
            <div class="card-body">
                @foreach(session('cart') as $id => $details)
                @if(!$loop->first)
                    <hr>
                @endif
                <div class="row cart-item mb-0">
                    <div class="col-md-3">
                        <img src="https://via.placeholder.com/100" alt="Product 1" class="img-fluid rounded">
                    </div>
                    <div class="col-md-5">
                        <h5 class="card-title">{{ $details['name'] }}</h5>
                        <p class="text-muted">Category: Electronics</p>
                    </div>
                    <div class="col-md-2">
                        <form action="{{ route('carts.changequantity') }}" method="POST">
                            @csrf
                            <div class="input-group">
                                <button class="btn btn-outline-secondary btn-sm" type="submit" name="action" value="decrease">-</button>
                                <input type="hidden" name="product_id" value="{{ $id }}">
                                <input style="max-width:100px" type="text" class="form-control  form-control-sm text-center quantity-input" value="{{ $details['quantity'] }}">
                                <button class="btn btn-outline-secondary btn-sm" type="submit" name="action" value="increase">+</button>
                            </div>
                        </form>
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
                    <span>$199.97</span>
                </div>
                <div class="d-flex justify-content-between mb-3">
                    <span>Shipping</span>
                    <span>$25.00</span>
                </div>
                <div class="d-flex justify-content-between mb-3">
                    <span>Tax</span>
                    <span>$20.00</span>
                </div>
                <hr>
                <div class="d-flex justify-content-between mb-4">
                    <strong>Total</strong>
                    <strong>${{ collect(session('cart'))->sum(fn($item) => $item['price'] * $item['quantity']) }}</strong>
                </div>
                <a href="{{ route('carts.delivery') }}" class="btn btn-primary w-100">Delivery and payment</a>
                <!-- <button class="btn btn-primary w-100">Proceed to Checkout</button> -->
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
                <!-- <button type="button" class="btn btn-primary position-relative">
                Mails <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-secondary">+99 <span class="visually-hidden">unread messages</span></span>
                </button> -->
            </div>
            <div class="card-body cart text-center">
            <i class="bi bi-cart3 mb-4 mr-3" style="font-size:80px;color: orange;"></i>
                <!-- <img src="https://i.imgur.com/dCdflKN.png" width="130" height="130" class="img-fluid mb-4 mr-3"> -->
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
        // Event listener for form submission
        $("#promo-form").on('submit', function(e) {
            e.preventDefault(); // Prevent the default form submission

            // Get form data
            let promoCode = $("#promo_code").val();
            let validFrom = $("#valid_from").val();
            let validUntil = $("#valid_until").val();

            // Send the form data via AJAX to the route
            $.ajax({
                url: '/carts/add-promo', // Route for adding the promo code
                type: 'POST',
                data: {
                    _token: "{{ csrf_token() }}", // CSRF token for security
                    promo_code: promoCode,
                    valid_from: validFrom,
                    valid_until: validUntil
                },
                success: function(response) {
                    // Show a success or failure message depending on the response
                    if (response.success) {
                        $("#response-message").html('<div class="alert alert-success">Promo code added successfully!</div>');
                        $("#promo-form")[0].reset(); // Clear the form fields
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