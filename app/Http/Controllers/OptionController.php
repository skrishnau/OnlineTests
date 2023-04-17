<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class OptionController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }
}
