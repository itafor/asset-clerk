<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TenantController extends Controller
{
    public function index()
    {
        return view('admin.tenant.index');
    }

    public function create()
    {
        return view('admin.tenant.create');
    }
}
