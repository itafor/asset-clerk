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

    public function myProfile()
    {
        return view('admin.tenant.my_profile');
    }

    public function myRent()
    {
        return view('admin.tenant.my_rent');
    }

    public function referals()
    {
        return view('admin.tenant.referals');
    }

    public function myMaintenance()
    {
        return view('admin.tenant.maintenance');
    }

    public function createMaintenance()
    {
        return view('admin.tenant.create_maintenance');
    }
}
