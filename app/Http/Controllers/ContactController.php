<?php

namespace App\Http\Controllers;

use App\Mail\AboutUsLetsTalkMail;
use Illuminate\Http\Request;
use App\Http\Requests\LetsTalkMailRequest;
use App\Http\Services\MailService;

class ContactController extends Controller
{
    protected $letsTalsMailService;

    public function __construct(MailService $letsTalsMailService)
    {
        $this->letsTalsMailService = $letsTalsMailService;
    }

    public function index()
    {
        return view('contacts.index');
    }

    public function sendMailLetsTalkMail(LetsTalkMailRequest $request)
    {
        $dataMail = $request->except('_token');
        $mailable = new AboutUsLetsTalkMail($dataMail);
        $author = 'zbiorentomologiczny@gmail.com';

        $this->letsTalsMailService->send($request, $mailable, $author);

        return redirect()->route('contacts.index')->with('success', 'Email send successfully.');
    }
}
