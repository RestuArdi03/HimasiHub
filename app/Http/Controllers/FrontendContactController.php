<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FrontendContactController extends Controller
{
    public function index()
    {
         return view('frontend.contact.index');
    }
}
