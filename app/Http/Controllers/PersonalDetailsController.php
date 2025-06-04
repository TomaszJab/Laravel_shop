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

    public function create()
    {
        $idUser = auth()->user()->id ?? null;
        if ($idUser) {
            $defaultPersonalDetails = $this->personalDetailsService->getDefaultPersonalDetailsByUserId($idUser);
        } else {
            $defaultPersonalDetails = null;
        }

        return view('cart.buyWithoutRegistration', compact('defaultPersonalDetails'));
    }

    public function walidate(PersonalDetailsRequest $request)
    {
        $personalDetails = $this->personalDetailsService->walidate($request);

        session(['personalDetails' => $personalDetails]);
        return redirect()->route('carts.show');
    }

    public function store(Request $request)
    {
        $userId = auth()->user()->id;

        $data = $request->except('_token');
        $data['user_id'] = $userId;

        $defaultPersonalDetails = $request->input('default_personal_details');
        if ($defaultPersonalDetails == "0") {
            $data['company_or_private_person'] = 'private_person';
        }

        if ($request->has('acceptance_of_the_regulations')) {
        } else {
            $data['acceptance_of_the_regulations'] = '-';
        }

        $this->personalDetailsService->store($request, $data);

        return redirect()->back()->with('success', 'Personal details saved successfully.');
    }
}
