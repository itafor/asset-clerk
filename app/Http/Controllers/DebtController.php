<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DebtController extends Controller
{
    public function debt()
    {
        return view('new.admin.debt.debt');
    }

    public function payment()
    {
        return view('new.admin.debt.payment');
    }
}
