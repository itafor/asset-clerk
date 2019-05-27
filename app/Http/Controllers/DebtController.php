<?php

namespace App\Http\Controllers;

use App\TenantRent;

class DebtController extends Controller
{
    public function debt()
    {
        $rentalsDueNotPaid = TenantRent::where('tenant_rents.user_id', getOwnerUserID())
        ->join('rent_dues as rd', 'rd.rent_id', '=', 'tenant_rents.id')
        ->where('rd.status', 'pending')
        ->whereRaw("rd.due_date < CURDATE()") // Get payments due
        ->orderBy('tenant_rents.id', 'desc')->select('tenant_rents.*')->get();
        
        return view('new.admin.debt.debt', compact('rentalsDueNotPaid'));
    }
}
