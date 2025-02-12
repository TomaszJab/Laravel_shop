@php
    $cart = session('cart');
    $products = array_filter($cart, 'is_array'); // Pobierz tylko produkty
    $subtotal = collect($products)->sum(fn($item) => $item['price'] * $item['quantity']);
    $shipping = $cart['delivery'];
    $payment = $cart['payment'];
    $total = $subtotal + $shipping + $payment;
@endphp