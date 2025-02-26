<div class="card" style="top: 0;">
            <div class="card-body">
                @foreach($products as $id => $details)
                    @if(!$loop->first)
                        <hr class="product-divider" id="divider-{{ $id }}">
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
                            <button @if($enableButtons) class="btn btn-outline-secondary btn-sm quantity-btn decrease"
                            @else class="btn btn-secondary btn-sm quantity-btn decrease disabled" @endif 
                            data-action="decrease" data-product-id="{{ $id }}" >-</button>

                            <input type="text" class="form-control form-control-sm text-center quantity-input" 
                            style="max-width:100px" value="{{ $details['quantity'] }}" 
                            @if($enableButtons)
                            readonly 
                            @else disabled @endif>

                            <button @if($enableButtons) class="btn btn-outline-secondary btn-sm quantity-btn increase"
                            @else class="btn btn-secondary btn-sm quantity-btn increase disabled" @endif
                            data-action="increase" data-product-id="{{ $id }}">+</button>
                        </div>
                        <!-- <div id="response-message"></div> -->
                    </div>
                    <div class="col-md-2 text-end">
                        <p class="fw-bold"  data-product-id="{{ $id }}">${{ number_format($details['price'] * $details['quantity'], 2) }}</p>
                        <!-- <form action="{{ route('carts.destroy',$id) }}" method="POST">

                            @csrf
                            @method('DELETE') -->
                            <button type="submit" 
                            @if($enableButtons) class="btn btn-sm btn-outline-danger delete-product"
                            @else class="btn btn-sm btn-danger delete-product increase disabled" @endif
                            data-product-id="{{ $id }}"><i class="bi bi-trash"></i></button>
                        <!-- </form> -->
                    </div>
                </div>
                @endforeach
            </div>
        </div>