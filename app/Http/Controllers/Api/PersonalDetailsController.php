<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Services\PersonalDetailsService;
use App\Http\Resources\PersonalDetailsResource;
use App\Http\Requests\PersonalDetailsRequest;

class PersonalDetailsController extends Controller
{
    protected $personalDetailsService;

    public function __construct(
        PersonalDetailsService $personalDetailsService
    ) {
        $this->personalDetailsService = $personalDetailsService;
    }

    //http://127.0.0.1:8000/api/cart/buy
    public function index()
    {
        $idUser = Auth::guard('sanctum')->user()->id ?? null;
        if ($idUser) {
            $defaultPersonalDetails = $this->personalDetailsService->getDefaultPersonalDetailsByUserId($idUser);
        } else {
            $defaultPersonalDetails = null;
        }

        return [
            'defaultPersonalDetails' => $defaultPersonalDetails ?
                PersonalDetailsResource::make($defaultPersonalDetails) : null
        ];
    }

    public function walidate(PersonalDetailsRequest $request)
    {
        $personalDetails = $this->personalDetailsService->walidate($request);

        return [
            'summary' => PersonalDetailsResource::make($personalDetails)
        ];
    }

    public function createDefaultPersonalDetails(PersonalDetailsRequest $request)
    {
        $userId = Auth::guard('sanctum')->user()->id ?? null;
        //$userId = auth()->user()->id;

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

        $personalDetails = $this->personalDetailsService->store($request, $data);

        return response()->json(PersonalDetailsResource::make($personalDetails), 201);
        //return redirect()->back()->with('success', 'Personal details saved successfully.');
    }
}
