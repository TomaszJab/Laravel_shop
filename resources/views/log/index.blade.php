@extends('products.layout')
@section('content')
<div class="container py-5">
<div class="row">
    <div class="col-sm-12 col-md-12 col-lg-4 col-12 mt-4">
        <div class="card">
            <div class="card-body m-3" >
            <h3 class="mb-5">Register</h3>
            
            <form action="{{ route('register') }}" method="POST" autocomplete="off">
                @csrf
                <div data-mdb-input-init class="form-outline mb-3">
                     @if ($errors->has('registration_name'))
                    <div class="mb-3">
                        <span class="text-danger">{{ $errors->first('registration_name') }}</span>
                    </div>
                    @endif
                    <input  type="text" name="registration_name" id="registration_name" class="form-control form-control-lg" />
                    <label class="form-label mt-1" for="registration_name">Name</label>
                </div>
                
                <div data-mdb-input-init class="form-outline mb-3">
                     @if ($errors->has('registration_email'))
                    <div class="mb-3">
                        <span class="text-danger">{{ $errors->first('registration_email') }}</span>
                    </div>
                    @endif
                    <input type="email" name="registration_email" id="registration_email" class="form-control form-control-lg" autocomplete="new-email"/>
                    <label class="form-label mt-1" for="registration_email">Email</label>
                </div>

                <div data-mdb-input-init class="form-outline mb-3">
                    @if ($errors->has('registration_password'))
                    <div class="mb-3">
                        <span class="text-danger">{{ $errors->first('registration_password') }}</span>
                    </div>
                    @endif
                    <input type="password" name="registration_password" id="registration_password" class="form-control form-control-lg" autocomplete="new-password"/>
                    <label class="form-label mt-1" for="registration_password">Password</label>
                </div>

                <!-- Confirm Password -->
                <div data-mdb-input-init class="form-outline mb-3">
                    @if ($errors->has('password_confirmation'))
                    <div class="mb-3">
                        <span class="text-danger">{{ $errors->first('password_confirmation') }}</span>
                    </div>
                    @endif
                    <input type="password" name="password_confirmation" id="password_confirmation" class="form-control form-control-lg" autocomplete="new-password"/>
                    <label class="form-label mt-1" for="password_confirmation">Password Confirmation</label>
                </div>

                <button class="btn btn-md btn-lg btn-primary w-100" type="submit">Register</button>
            </form>
            
            <hr class="my-4">
            <button data-mdb-button-init data-mdb-ripple-init class="btn btn-md btn-lg btn-primary w-100" style="background-color: #dd4b39;"
                type="submit"><i class="fab fa-google me-2"></i> Sign in with google</button>
                <button data-mdb-button-init data-mdb-ripple-init class="btn btn-md btn-lg btn-primary mt-2 w-100" style="background-color: #3b5998;"
                type="submit"><i class="fab fa-facebook-f me-2"></i>Sign in with facebook</button>
            </div>
        </div>
    </div>
    <div class="col-sm-12 col-md-12 col-lg-4 col-12 mt-4">
        <div class="card">
            <div class="card-body m-3" >
                <h3 class="mb-5">Shopping without registration</h3>
                <strong>You do not need to create an account in our store to place an order.</strong>
                <p class="text-start mt-3 mb-3">Select the "Create Order" button.</p>
                <a href="/cart/buyWithoutRegistration" class="btn btn-md btn-lg btn-primary w-100">Create Order</a>
            </div>
        </div>
    </div>
    <div class="col-sm-12 col-md-12 col-lg-4 col-12 mt-4">
        <div class="card">
            <div class="card-body m-3 text-center" >
                <h3 class="mb-5">Sign in</h3>

                <form action="{{ route('login') }}" method="POST">
                @csrf
                    <div data-mdb-input-init class="form-outline mb-3">
                        @if ($errors->has('email'))
                        <div class="mb-3">
                            <span class="text-danger">{{ $errors->first('email') }}</span>
                        </div>
                        @endif
                        <input type="email" name="email" id="email" class="form-control form-control-lg" />
                        <label class="form-label mt-1" for="email">Email</label>
                    </div>

                    <div data-mdb-input-init class="form-outline mb-3">
                        @if ($errors->has('password'))
                        <div class="mb-3">
                            <span class="text-danger">{{ $errors->first('password') }}</span>
                        </div>
                        @endif
                        <input type="password" name="password" id="password" class="form-control form-control-lg" />
                        <label class="form-label mt-1" for="password">Password</label>
                    </div>

                    <!-- Checkbox -->
                    <div class="form-check d-flex justify-content-start mb-4">
                        <input class="form-check-input" type="checkbox" value="" id="form1Example3" />
                        <label class="form-check-label" for="form1Example3">&nbsp;Remember password</label>
                    </div>

                    <button class="btn btn-md btn-lg btn-primary w-100" type="submit">Login</button>
                </form>

                <hr class="my-4">

                <button data-mdb-button-init data-mdb-ripple-init class="btn btn-md btn-lg btn-primary w-100" style="background-color: #dd4b39;"
                type="submit"><i class="fab fa-google me-2"></i> Sign in with google</button>
                <button data-mdb-button-init data-mdb-ripple-init class="btn btn-md btn-lg btn-primary mt-2 w-100" style="background-color: #3b5998;"
                type="submit"><i class="fab fa-facebook-f me-2"></i>Sign in with facebook</button>
            </div>
        </div>
    </div>
</div>
</div>
@endsection