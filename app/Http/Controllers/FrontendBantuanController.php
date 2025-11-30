<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FrontendBantuanController extends Controller
{
    public function index()
    {
         return view('frontend.bantuan.index');
    }
}
