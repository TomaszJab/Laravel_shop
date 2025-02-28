<?php

namespace App\Http\Controllers;
use App\Mail\AboutUsLetsTalkMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function index()
    {
        return view('contacts.index');
    }

    public function sendMailLetsTalkMail(Request $request)
    {
        Mail::to('zbiorentomologiczny@gmail.com')->send(new AboutUsLetsTalkMail($request));
        return redirect()->route('contacts.index')->with('success','Email send successfully.');
    }
}
