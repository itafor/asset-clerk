<?php

namespace App\Http\Controllers;

use App\TenantRent;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $rentals = TenantRent::where('user_id', getOwnerUserID())
        ->orderBy('id', 'desc')->get();

        $data = [
            'rentals' => $rentals
        ];
        return view('dashboard', $data);
    }
}
