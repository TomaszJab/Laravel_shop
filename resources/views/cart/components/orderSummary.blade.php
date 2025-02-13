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