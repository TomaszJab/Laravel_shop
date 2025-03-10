@extends('products.layout')
@section('content')
<div class="container">
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
                            <div class="form-group">
                            $25.00 <input class="radio-inline" value="$25.00" name="radio-delivery" type="radio" onclick="ChangePrice(this.value,'Kurier')" @if($method_delivery == 'Kurier') checked @endif>
                            </div>
                        </div>
                        <div class="d-flex justify-content-between mb-3">
                            <span>Odbiór własny</span>
                            <div class="form-group">
                            $0.00 <input class="radio-inline" value="$0.00" name="radio-delivery" type="radio" onclick="ChangePrice(this.value,'odbior wlasny')" @if($method_delivery == 'odbior wlasny') checked @endif>
                            </div>
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
                            <div class="form-group">
                            $0.00 <input class="radio-inline" value="$0.00" name="radio-pay" type="radio" onclick="ChangePayment(this.value,'AutoPay')" @if($method_payment =='AutoPay') checked @endif>
                            </div>
                        </div>
                        <div class="d-flex justify-content-between mb-3">
                            <span>Karty płatnicze</span>
                            <div class="form-group">
                            $0.00 <input class="radio-inline" value="$0.00" name="radio-pay" type="radio" onclick="ChangePayment(this.value,'Karty płatnicze')" @if($method_payment =='Karty płatnicze') checked @endif>
                            </div>
                        </div>
                        <div class="d-flex justify-content-between mb-3">
                            <span>Google Pay</span>
                            <div class="form-group">
                            $0.00 <input class="radio-inline" value="$0.00" name="radio-pay" type="radio" onclick="ChangePayment(this.value,'Google Pay')" @if($method_payment =='Google Pay') checked @endif>
                            </div>
                        </div>
                        <div class="d-flex justify-content-between mb-3">
                            <span>Blik</span>
                            <div class="form-group">
                            $0.00 <input class="radio-inline" value="$0.00" name="radio-pay" type="radio" onclick="ChangePayment(this.value,'Blik')" @if($method_payment =='Blik') checked @endif>
                            </div>
                        </div>
                        <div class="d-flex justify-content-between mb-3">
                            <span>Szybki przelew online</span>
                            <div class="form-group">
                            $0.00 <input class="radio-inline" value="$0.00" name="radio-pay" type="radio" onclick="ChangePayment(this.value,'Szybki przelew online')" @if($method_payment =='Szybki przelew online') checked @endif>
                            </div>
                        </div>
                        <div class="d-flex justify-content-between mb-3">
                            <span>Płatność przy odbiorze</span>
                            <div class="form-group">
                            $24.00 <input class="radio-inline" value="$24.00" name="radio-pay" type="radio" onclick="ChangePayment(this.value,'Płatność przy odbiorze')" @if($method_payment =='Płatność przy odbiorze') checked @endif>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

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
                
                @include('cart.components.orderSummary')
                
                <a href="/cart/order" class="btn btn-primary w-100">Proceed to Checkout</a>
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
</div>
<script>
function ChangePrice(price,method) {
  document.getElementById("shippingValue").textContent = price;
  Change(price,method,"Price");
}

function ChangePayment(price,method) {
  document.getElementById("paymentValue").textContent = price;
  Change(price,method,"Payment");
}

function Change(price,method,change) {
    $.ajax({
        url: "{{ route('carts.changePrice') }}",
        type: "POST",
        data: {
            _token: "{{ csrf_token() }}",
            price: price,
            method: method,
            change: change
        },
    success: function(response) {
        changeDisplayValue();
        console.log("Change: ok");
    },
    error: function(xhr, status, error) {
        console.log("Wystąpił błąd przy aktualizacji: ");
    }});
}

function changeDisplayValue(subtotalValue=null) {

if(subtotalValue == null){
    subtotalValue = document.getElementById("subtotalValue").innerHTML;
    subtotalValue = parseFloat(subtotalValue.replace("$", ""));
}else{
    subtotalValue = parseFloat(subtotalValue);
}

let shippingValue = document.getElementById("shippingValue").innerHTML;
let paymentValue = document.getElementById("paymentValue").innerHTML;

shippingValue = parseFloat(shippingValue.replace("$", ""));
paymentValue = parseFloat(paymentValue.replace("$", ""));
let totalValue = subtotalValue + shippingValue + paymentValue;

let discountValue = document.getElementById("discountValue").innerHTML;

if(discountValue!='%'){
    discountValue = parseFloat(discountValue.replace("%", ""));
    totalValue = totalValue - (totalValue/discountValue);
}

$('#totalValue').text('$' + totalValue.toFixed(2));
}
</script>

@endsection