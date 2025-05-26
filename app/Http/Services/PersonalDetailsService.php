<?php

namespace App\Http\Services;

use App\Http\Controllers\Controller;
use App\Models\personalDetails;
use Illuminate\Http\Request;
use App\Http\Requests\PersonalDetailsRequest;

class PersonalDetailsService extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    public function getPersonalDetailByPersonalDetailsId(int $personal_details_id)
    {
        return personalDetails::where('id', $personal_details_id)->first();
    }

    public function getDefaultPersonalDetailsByUserId(int $idUser)
    {
        return personalDetails::where('user_id', $idUser)->where('default_personal_details', '1')->latest()->first();
    }

    public function getAdditionalPersonalDetailsByUserId(int $idUser)
    {
        return personalDetails::where('user_id', $idUser)->where('default_personal_details', '0')->latest()->first();
    }

    public function storeWithoutRegistration(PersonalDetailsRequest $request)
    {
        $request->validated();
        $personalDetails = $request->except('_token');
        return new PersonalDetails($personalDetails);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PersonalDetailsRequest $request, array $data)
    {
        $request->validated();
        $product = personalDetails::create($data);
        return $product;
    }

    /**
     * Display the specified resource.
     */
    public function show(personalDetails $personalDetails)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, personalDetails $personalDetails)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(personalDetails $personalDetails)
    {
        //
    }
}
