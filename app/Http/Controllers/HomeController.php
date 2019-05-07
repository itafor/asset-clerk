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
        
        $rentalsDue = TenantRent::where('tenant_rents.user_id', getOwnerUserID())
        ->join('rent_dues as rd', 'rd.rent_id', '=', 'tenant_rents.id')
        ->where('rd.status', 'pending')
        ->whereRaw("rd.due_date BETWEEN CURDATE() AND DATE_ADD(CURDATE(), INTERVAL 30 DAY)") // Get payments due in next 30 days
        ->orderBy('tenant_rents.id', 'desc')->select('tenant_rents.*')->get();

        $rentalsDueNotPaid = TenantRent::where('tenant_rents.user_id', getOwnerUserID())
        ->join('rent_dues as rd', 'rd.rent_id', '=', 'tenant_rents.id')
        ->where('rd.status', 'pending')
        ->whereRaw("rd.due_date < CURDATE()") // Get payments due
        ->orderBy('tenant_rents.id', 'desc')->select('tenant_rents.*')->get();

        $data = [
            'rentals' => $rentals,
            'rentalsDue' => $rentalsDue,
            'rentalsDueNotPaid' => $rentalsDueNotPaid,
        ];
        return view('new.dashboard', $data);
    }
}
