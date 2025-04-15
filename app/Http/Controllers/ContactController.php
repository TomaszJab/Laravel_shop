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
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'message' => 'required',
        ]);

        $dataMail = $request->except('_token');

        Mail::to('zbiorentomologiczny@gmail.com')->send(new AboutUsLetsTalkMail($dataMail));
        return redirect()->route('contacts.index')->with('success', 'Email send successfully.');
    }
}
