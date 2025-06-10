<?php

namespace App\Http\Services;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Statute;
use Illuminate\Support\Str;

//use App\Http\Requests\StatuteRequest;

class StatuteService extends Controller
{
    /**
     * Display a listing of the resource.
     */
    //index test
    public function getAllStatutes()
    {
        return Statute::all();
    }

    public function getAllStatuteTransformContentAndPaginate($paginate)
    {
        $statutes = Statute::paginate($paginate);
        $statutes->getCollection()->transform(function ($item) {
            $item->content = Str::limit($item->content, 20, '...');
            return $item;
        });
        return $statutes;
    }
}
