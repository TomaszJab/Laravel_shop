@extends('products.layout')
@section('content')
<div class="row">
    <div class="col-sm-12 col-md-12 col-lg-4 col-12 mt-4">
        <div class="card">
            <div class="card-body m-3" >
            <h3 class="mb-5">Zarejetruj się</h3>
            <strong>Załóż konto, aby skorzystać z przywilejów dla stałych klientów:</strong>
            <ul class="mt-3">
                <li>podgląd statusu realizacji zamówień i historii zakupów</li>
                <li>brak konieczności wprowadzania swoich danych przy kolejnych zakupach</li>
                <li>możliwość otrzymania rabatów i kuponów promocyjnych</li>
            </ul>
            <button class="btn btn-md btn-lg btn-primary w-100" type="submit">Zarejetruj się</button>
            
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
            <h3 class="mb-5">Zakupy bez rejestracji</h3>
            <strong>Aby złożyć zamówienie nie musisz zakładać konta w naszym sklepie.</strong>
            <p class="text-start mt-3 mb-3">Wybierz przycisk "Złóż zamówienie".</p>
            <button class="btn btn-md btn-lg btn-primary w-100" type="submit">Złóż zamówienie</button>

            </div>
        </div>
    </div>
    <div class="col-sm-12 col-md-12 col-lg-4 col-12 mt-4">
        <div class="card">
            <div class="card-body m-3 text-center" >
                <h3 class="mb-5">Sign in</h3>
                <div data-mdb-input-init class="form-outline mb-3">
                    <input type="email" id="typeEmailX-2" class="form-control form-control-lg" />
                    <label class="form-label mt-1" for="typeEmailX-2">Email</label>
                </div>

                <div data-mdb-input-init class="form-outline mb-3">
                    <input type="password" id="typePasswordX-2" class="form-control form-control-lg" />
                    <label class="form-label mt-1" for="typePasswordX-2">Password</label>
                </div>

                <!-- Checkbox -->
                <div class="form-check d-flex justify-content-start mb-4">
                    <input class="form-check-input" type="checkbox" value="" id="form1Example3" />
                    <label class="form-check-label" for="form1Example3">&nbsp;Remember password</label>
                </div>

                <button data-mdb-button-init data-mdb-ripple-init class="btn btn-md btn-lg btn-primary w-100" type="submit">Login</button>

                <hr class="my-4">

                <button data-mdb-button-init data-mdb-ripple-init class="btn btn-md btn-lg btn-primary w-100" style="background-color: #dd4b39;"
                type="submit"><i class="fab fa-google me-2"></i> Sign in with google</button>
                <button data-mdb-button-init data-mdb-ripple-init class="btn btn-md btn-lg btn-primary mt-2 w-100" style="background-color: #3b5998;"
                type="submit"><i class="fab fa-facebook-f me-2"></i>Sign in with facebook</button>
            </div>
        </div>
    </div>
</div>
@endsection