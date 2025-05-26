<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\LetsTalkMailRequest;
use App\Http\Services\MailService;
use App\Mail\AboutUsLetsTalkMail;

class ContactController extends Controller
{
    protected $letsTalsMailService;

    public function __construct(MailService $letsTalsMailService)
    {
        $this->letsTalsMailService = $letsTalsMailService;
    }

    /**
     * Display a listing of the resource.
     */
    // public function index()
    // {
    //     //return view('contacts.index');
    // }

    public function sendMailLetsTalkMail(LetsTalkMailRequest $request)
    {
        $dataMail = $request->except('_token');
        $mailable = new AboutUsLetsTalkMail($dataMail);
        $author = 'zbiorentomologiczny@gmail.com';

        $this->letsTalsMailService->send($request, $mailable, $author);

        return response()->json(['success' => 'Email send successfully.']);
    }

    /**
     * Store a newly created resource in storage.
     */
    // public function store(Request $request)
    // {
    //     //
    // }

    /**
     * Display the specified resource.
     */
    // public function show(string $id)
    // {
    //     //
    // }

    /**
     * Update the specified resource in storage.
     */
    // public function update(Request $request, string $id)
    // {
    //     //
    // }

    /**
     * Remove the specified resource from storage.
     */
    // public function destroy(string $id)
    // {
    //     //
    // }
}
