@extends('products.layout')
@section('content')

<section class="text-center p-5 bg-primary text-white">
    <div class="container">
        <h1 class="jumbotron-heading">Contact us</h1>
        <p class="mb-0">You can write to us...</p>
    </div>
</section>

<div class="container">
    @if ($errors->any())
        <div class="alert alert-danger mt-4">
        @foreach ($errors->all() as $error)
            <p>{{ $error }}</p>
        @endforeach
        </div>
    @endif
    @if ($message = Session::get('success'))
        <div class="alert alert-success mt-4">
        {{ $message }}
        </div>
    @endif

    <div class="py-5">
        <form action="{{ route('contacts.sendMail') }}" method="post">
            @csrf
            <div class="row mb-2">
                <div class="col">
                    <label class="mb-2" for="name">Name:<span class="text-danger"> *</span></label>
                    <input class="form-control" name="name" placeholder="Name..." />
                </div>
                <div class="col">
                    <label class="mb-2" for="email">Email:<span class="text-danger"> *</span></label>
                    <input class="form-control" name="email" placeholder="E-mail..." />
                </div>
            </div>

            <div class="form-group mb-2">
                <label class="mb-2" for="phone">Phone:</label>
                <input class="form-control" name="phone" placeholder="Phone..." />
            </div>

            <div class="form-group">
                <label class="mb-2" for="message">Message:<span class="text-danger"> *</span></label>
                <textarea class="form-control" name="message" placeholder="How can we help you?" style="height:150px;"></textarea><br />
            </div>

            <div class="text-end">
                <input class="btn btn-primary" type="submit" value="Let's Talk" /><br /><br />
            </div>
        </form>
    </div>
</div>

   
<section class="d-flex align-items-center p-5" style="background-color: rgb(233, 236, 239);">
    <div class="ratio ratio-21x9">
        <iframe src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d12079.173754434265!2d-73.84717976289762!3d40.81053271781142!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x89c28b283cbc77c9%3A0x53dae8b6428164ff!2sFerry%20Point%20Park!5e0!3m2!1spl!2spl!4v1734954721167!5m2!1spl!2spl" 
            width="10" 
            height="10" 
            style="border:0;" 
            allowfullscreen=""
            loading="lazy" 
            referrerpolicy="no-referrer-when-downgrade">
        </iframe>
    </div>
</section>
@endsection