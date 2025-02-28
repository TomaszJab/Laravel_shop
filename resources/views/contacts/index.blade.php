@extends('products.layout')
@section('content')
<div class="container">
<div class="row">
    <div class="col-md-12 mt-4">
        @if ($message = Session::get('success'))
            <div class="alert alert-success">
                <p>{{ $message }}</p>
            </div>
        @endif
    </div>
</div>

<div class="mt-4 p-5 bg-primary text-white rounded">
  <h1>Contact us</h1>
  <p>You can write to us...</p>
</div><br />

<div class="card bg-light">
    <div class="row card-body">
        <div class="col-md-4">
                <b>Customer service:</b> <br />
                Phone: +1 129 209 291<br />
                E-mail: <a href="mailto:support@mysite.com">support@mysite.com</a><br />
                <br /><br />
                <b>Headquarter:</b><br />
                Company Inc, <br />
                Las vegas street 201<br />
                55001 Nevada, USA<br />
                Phone: +1 145 000 101<br />
                <a href="mailto:usa@mysite.com">usa@mysite.com</a><br />

                <br /><br />
                <b>Hong kong:</b><br />
                Company HK Litd, <br />
                25/F.168 Queen<br />
                Wan Chai District, Hong Kong<br />
                Phone: +852 129 209 291<br />
                <a href="mailto:hk@mysite.com">hk@mysite.com</a><br />
        </div>

        <div class="col-md-8">
                <form action="{{ route('contacts.sendMailLetsTalkMail') }}" method="post">
                @csrf
                    <input class="form-control" name="name" placeholder="Name..." /><br />
                    <input class="form-control" name="phone" placeholder="Phone..." /><br />
                    <input class="form-control" name="email" placeholder="E-mail..." /><br />
                    <textarea class="form-control" name="text" placeholder="How can we help you?" style="height:150px;"></textarea><br />
                    <input class="btn btn-primary" type="submit" value="Let's Talk" /><br /><br />
                </form>
        </div>
    </div>    
</div><br/>
<div class="card bg-light">
    <div class="row card-body">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
            <b>Lokalizacja:</b>
            </div><br/>
            <div class="ratio ratio-4x3" style="max-height: 300px;">
            <iframe src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d12079.173754434265!2d-73.84717976289762!3d40.81053271781142!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x89c28b283cbc77c9%3A0x53dae8b6428164ff!2sFerry%20Point%20Park!5e0!3m2!1spl!2spl!4v1734954721167!5m2!1spl!2spl" 
                width="10" 
                height="10" 
                style="border:0;" 
                allowfullscreen=""
                loading="lazy" 
                referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div>
        </div>
    </div>
</div>
</div>
@endsection