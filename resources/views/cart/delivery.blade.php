@extends('products.layout')
@section('content')
<div class="row">
    <div class="col-md-12 col-sm-12 mt-4 mb-4 p-4 bg-primary text-white rounded">
        <h1>Your delivery</h1>
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
        <div class="row">
            <div class="col-lg-6 mb-4">
                <div class="card" style="top: 0; background-color:rgb(232, 255, 208);">
                    <div class="card-body">
                        <h5 class="card-title mb-4">Delivery</h5>
                        <div class="d-flex justify-content-between mb-3">
                            <span>Kurier</span>
                            <span>$25</span>
                        </div>
                        <div class="d-flex justify-content-between mb-3">
                            <span>Odbiór własny</span>
                            <span>$0</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 mb-4">
                <div class="card" style="top: 0; background-color:rgb(255, 255, 182);">
                    <div class="card-body" >
                        <h5 class="card-title mb-4">Payment</h5>
                        <div class="d-flex justify-content-between mb-3">
                            <span>AutoPay</span>
                            <span>$0</span>
                        </div>
                        <div class="d-flex justify-content-between mb-3">
                            <span>Karty płatnicze</span>
                            <span>$0</span>
                        </div>
                        <div class="d-flex justify-content-between mb-3">
                            <span>Google Pay</span>
                            <span>$0</span>
                        </div>
                        <div class="d-flex justify-content-between mb-3">
                            <span>Blik</span>
                            <span>$0</span>
                        </div>
                        <div class="d-flex justify-content-between mb-3">
                            <span>Szybki przelew online</span>
                            <span>$0</span>
                        </div>
                        <div class="d-flex justify-content-between mb-3">
                            <span>Płatność przy odbiorze</span>
                            <span>$24</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- <br/> -->
        <div class="row botton">
            <div class="col-6 col-md-6 text-start">
                <!-- Continue Shopping Button -->
                <a href="{{ route('products.index') }}" class="btn btn-outline-primary">
                    <i class="bi bi-arrow-left me-2"></i>Continue Shopping
                </a>
            </div>
            <div class="col-6 col-md-6 text-end">
                <!-- Continue Shopping Button -->
                <a href="{{ route('carts.index') }}" class="btn btn-outline-primary">
                    <i class="bi bi-arrow-left me-2"></i>Back to Cart
                </a>
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
                    <span>$10.00</span>
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
                <a href="{{ route('carts.buyWithoutRegistration') }}" class="btn btn-primary w-100">Proceed to Checkout</a>
                <!-- <button class="btn btn-primary w-100">Proceed to Checkout</button> -->
            </div>
        </div>
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

@endsection