<?php

namespace App\Http\Services;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Mail\Mailable;
use Illuminate\Support\Facades\Mail;

class MailService extends Controller
{
    public function send(Request $request, Mailable $mailable, string $author)
    {
        $request->validated();
        Mail::to($author)->send($mailable);
    }
}
