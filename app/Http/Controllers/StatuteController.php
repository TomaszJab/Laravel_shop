<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StatuteController extends Controller
{
    public function index()
    {
        return view('statude.index');
    }
}
