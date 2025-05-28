<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Services\PersonalDetailsService;
use App\Http\Resources\PersonalDetailsResource;

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
}
