<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PersonalDetails;
use App\Http\Requests\PersonalDetailsRequest;
use App\Http\Services\PersonalDetailsService;

class PersonalDetailsController extends Controller
{
    protected $personalDetailsService;

    public function __construct(
        PersonalDetailsService $personalDetailsService
    ) {
        $this->personalDetailsService = $personalDetailsService;
    }

    public function index()
    {
        $idUser = auth()->user()->id ?? null;
        if ($idUser) {
            $defaultPersonalDetails = PersonalDetails::where('user_id', $idUser)
                ->where('default_personal_details', '1')->latest()->first();
            //$additionalPersonalDetails = personalDetails::where('user_id', $idUser)
            //->where('default_personal_details', '0')->latest()->first();
            //return view('cart.buyWithoutRegistration',['defaultPersonalDetails' => $defaultPersonalDetails]);
        } else {
            $defaultPersonalDetails = null;
            //return view('cart.buyWithoutRegistration', compact('defaultPersonalDetails'));
        }
        return view('cart.buyWithoutRegistration', compact('defaultPersonalDetails'));
    }

    public function walidate(PersonalDetailsRequest $request)
    {
        $personalDetails = $this->personalDetailsService->walidate($request);

        session(['cart_summary' => $personalDetails]);
        return redirect()->route('carts.summary');
    }

    public function createDefaultPersonalDetails(Request $request)
    {
        $userId = auth()->user()->id;

        $data = $request->except('_token');
        $data['user_id'] = $userId;

        $defaultPersonalDetails = $request->input('default_personal_details');
        if ($defaultPersonalDetails == "0") {
            $data['company_or_private_person'] = 'private_person';
        }

        $companyOrPrivatePerson = $data['company_or_private_person'];

        $rules = [
            'email' => 'required',
            'firstName' => 'required',
            'lastName' => 'required',
            'phone' => 'required',

            'street' => 'required',
            'house_number' => 'required',
            'zip_code' => 'required',
            'city' => 'required',
        ];

        if ($request->has('acceptance_of_the_regulations')) {
            $rules['acceptance_of_the_regulations'] = 'required';
        } else {
            $data['acceptance_of_the_regulations'] = '-';
        }

        if ($companyOrPrivatePerson == 'private_person') {
        } else {
            $rules['company_name'] = 'required';
            $rules['nip'] = 'required';
        }

        $request->validate($rules);
        PersonalDetails::create($data);

        return redirect()->back()->with('success', 'Personal details saved successfully.');
    }
}
