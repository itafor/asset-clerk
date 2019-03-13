<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function assets()
    {
        return view('admin.report.assets');
    }

    public function payments()
    {
        return view('admin.report.payment');
    }
    
    public function approvals()
    {
        return view('admin.report.approvals');
    }
    
    public function maintenance()
    {
        return view('admin.report.maintenance');
    }

    public function legal()
    {
        return view('admin.report.legal');
    }
}
