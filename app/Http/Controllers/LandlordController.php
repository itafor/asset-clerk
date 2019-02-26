<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LandlordController extends Controller
{
    public function index()
    {
        return view('admin.landlord.index');
    }

    public function create()
    {
        return view('admin.landlord.create');
    }
}
