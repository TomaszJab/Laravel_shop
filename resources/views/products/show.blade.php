@extends('products.layout')
@section('content')
<div class="container">
    <!-- <div class="row">
        <div class="col-lg-12 mb-3">
            <a class="btn btn-warning" href="{{ route('products.index') }}"> Back</a>
        </div>
    </div> -->
    <div class="row mt-5">
        <div class="col-sm-5 col-12">
            <div class="card">
               
                <div id="carouselExampleSlidesOnly" class="carousel slide" >
                    <div id="carouselExampleSlidesOnly" class="carousel slide" data-bs-ride="carousel">
                        <div class="carousel-inner">
                            <div class="carousel-item active">
                                <div class="d-block img-fluid rounded p-2" style="height: 450px; background: #aaa;">Fake Image1</div>
                            </div>
                            <div class="carousel-item">
                                <div class="d-block img-fluid rounded p-2" style="height: 450px; background: #aaa;">Fake Image2</div>
                            </div>
                            <div class="carousel-item">
                                <div class="d-block img-fluid rounded p-2" style="height: 450px; background: #aaa;">Fake Image3</div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="multi-carousel" data-mdb-interval="3000">
                        <div class="d-flex justify-content-center">
                            <button data-mdb-button-init class="carousel-control-prev btn btn-pink btn-floating mx-3" type="button" tabindex="0" data-mdb-slide="prev">
                                <i class="fas fa-angle-left fa-lg"></i>
                            </button>
                            <button data-mdb-button-init class="carousel-control-next btn btn-pink btn-floating mx-3" type="button" tabindex="0" data-mdb-slide="next">
                                <i class="fas fa-angle-right fa-lg"></i>
                            </button>
                        </div>
                        <div class="multi-carousel-inner" style="display: flex;">
                            <div class="multi-carousel-item">
                                <div class="d-block fakeimg img-fluid rounded p-2" style="max-height: 100px; max-width: 100px;">Fake Image1</div>
                            </div>
                            
                            <div class="multi-carousel-item">
                                <div class="d-block fakeimg img-fluid rounded p-2" style="max-height: 100px; max-width: 100px;">Fake Image2</div>
                            </div>

                            <div class="multi-carousel-item">
                                <div class="d-block fakeimg img-fluid rounded p-2" style="max-height: 100px; max-width: 100px;">Fake Image3</div>
                            </div>
                        </div>
                    </div>`
            </div>
        </div>
        <div class="col-sm-7 col-12">
            <div class="card">
                <div class="card-body p-4">
                    <div class="form-group">
                        <h3>{{ $product->name }}</h3>
                    </div>
                    <div class="form-group pt-3">
                        ${{ $product->price }}
                    </div>
                    <div class="form-group pt-3">
                        <strong>Brand:</strong>
                        Easy Wear
                    </div>
                    <div class="form-group pt-3">
                        <strong>Description:</strong>
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod temp incididunt ut labore et dolore magna aliqua. Quis ipsum suspendisse. Donec condimentum elementum convallis. Nunc sed orci a diam ultrices aliquet interdum quis nulla.
                    </div>
                    <div class="form-group pt-3">
                        <strong>Avaliable Color:</strong>
                        White / Black
                    </div>
                    <div class="form-group pt-3">
                        <strong>Specification:</strong>
                        Lorem ipsum dolor sit
                        Amet, consectetur
                        Adipiscing elit,set
                        Duis aute irure
                        Ut enim ad minim
                        Dolore magna aliqua
                        Excepteur sint
                    </div>
                    
                    <div class="form-group pt-3">
                        <strong>Details:</strong>
                        {{ $product->detail }}
                    </div>
                    <div class="row">
                        <div class="col-xl-4 col-lg-6 col-md-12 d-flex gap-2 pt-3">
                            <strong>Size:</strong>
                            &nbsp
                            <input type="radio" class="btn-check" name="size" value="S" id="size_S" autocomplete="off">
                            <label class="btn btn-sm btn-success" for="size_S">S</label>
                            
                            <input type="radio" class="btn-check" name="size" value="M" id="size_M" autocomplete="off">
                            <label class="btn btn-sm btn-success" for="size_M">M</label>
                            
                            <input type="radio" class="btn-check" name="size" value="L" id="size_L" autocomplete="off" checked>
                            <label class="btn btn-sm btn-success" for="size_L">L</label>
                            
                            <input type="radio" class="btn-check" name="size" value="XL" id="size_XL" autocomplete="off">
                            <label type="button" class="btn btn-sm btn-success" for="size_XL">XL</label>&nbsp
                        </div></br>
                        <div class="col-xl-8 col-lg-6 col-md-12 d-flex gap-2 pt-3">
                            <strong>Quantity:</strong>
                            <div class="input-group">
                                <input class="btn btn-sm btn-success" type="button" value="-" onclick="changeQuantity('-')">
                                <input type="text" class="text-center" id="quantity-input" value="1" style="max-width:50px" readonly>
                                <input class="btn btn-sm btn-success" type="button" value="+" onclick="changeQuantity('+')">
                            </div>
                        </div>
                    </div>
                    <div class="row pt-5">
                        <form class="w-50" action="{{ route('products.add_to_cart', $product->id) }}" method="POST" onsubmit="updateHiddenSize('1')">
                            @csrf
                            <input type="hidden" name="size" id="selectedSize1" value="L">
                            <input type="hidden" name="quantity" id="quantity-input1">

                            <button type="submit" class="btn btn-lg btn-primary w-100">Buy</button>
                        </form>
                        <form class="w-50" action="{{ route('products.add_to_cart', $product->id) }}" method="POST" onsubmit="updateHiddenSize('2')">
                            @csrf
                            <input type="hidden" name="size" id="selectedSize2" value="L">
                            <input type="hidden" name="quantity" id="quantity-input2">
                            <button type="submit" class="btn btn-lg btn-primary w-100">Add to cart</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <h3>Add comment</h3>

    <form action="{{ route('products.comments.store', ['product' => $product->id]) }}" method="POST">
    @csrf
     <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Author:</strong>
                <input type="text" name="author" class="form-control" placeholder="Author">
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Content:</strong>
                <textarea class="form-control" style="height:150px" name="content" placeholder="Content"></textarea>
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                <button type="submit" class="btn btn-primary">Add Comment</button>
        </div>
    </div>
</form>
<h3>Comments</h3>
<ul>
    @foreach ($product->comments as $comment)
        <li>
            <strong>{{ $comment->author }}</strong>: {{ $comment->content }}
        </li>
    @endforeach
</ul>
</div>
@endsection

<script>
    function updateHiddenSize(hiddenInputId) {
        const selectedSize = document.querySelector('input[name="size"]:checked');
        if (selectedSize) {
            document.getElementById('selectedSize' + hiddenInputId).value = selectedSize.value;
        }
        let quantity_input_value = document.getElementById('quantity-input').value;
        document.getElementById('quantity-input' + hiddenInputId).value = quantity_input_value;
    }

    function changeQuantity(increaseDecrease){
        let quantity_input_value = parseInt(document.getElementById('quantity-input').value);

        if(increaseDecrease == '+'){
            document.getElementById('quantity-input').value = quantity_input_value + 1;

        }else if(increaseDecrease == '-'){
            if(quantity_input_value > 1){
                document.getElementById('quantity-input').value = quantity_input_value - 1;
            }
        }
    }
</script>