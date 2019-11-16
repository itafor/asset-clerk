<?php

namespace App\Http\Controllers;

use App\Asset;
use App\Landlord;
use App\Subscription;
use App\Tenant;
use App\TenantRent;
use App\Transaction;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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
        $user_role = Auth::user()->role;
        if ($user_role !== 'admin') {
            $rentals = TenantRent::where('user_id', getOwnerUserID())
                ->orderBy('id', 'desc')->get();

            $rentalsDueInNextThreeMonths = TenantRent::where('tenant_rents.user_id', getOwnerUserID())
                ->whereRaw("due_date BETWEEN CURDATE() AND DATE_ADD(CURDATE(), INTERVAL 120 DAY)")// Get payments due in next 120 days
                ->orderBy('tenant_rents.id', 'desc')->select('tenant_rents.*',DB::raw('TIMESTAMPDIFF(DAY,CURDATE(),tenant_rents.due_date) AS remaingdays'))->get();

            $rentalsDueNotPaid = TenantRent::where('tenant_rents.user_id', getOwnerUserID())
                ->where('status', 'pending')
                ->whereRaw("due_date < CURDATE()")// Get payments due
                ->orderBy('tenant_rents.id', 'desc')->select('tenant_rents.*')->get();

        $renewedRentals = TenantRent::where('tenant_rents.user_id', getOwnerUserID())
                ->where('new_rental_status','New')
                ->orderBy('tenant_rents.id', 'desc')->select('tenant_rents.*')->get();

            $data = [
                'rentals' => $rentals,
                'rentalsDue' => $rentalsDueInNextThreeMonths,
                'rentalsDueNotPaid' => $rentalsDueNotPaid,
            ];
            return view('new.dashboard',compact('rentalsDueInNextThreeMonths','renewedRentals'),$data);
        } else {
            $users = User::where('role', 'agent')->count();
            $landlords = Landlord::count();
            $subscriptions = Subscription::count();
            $active_subscriptions = Subscription::where('status', 'active')->count();
            $properties = Asset::count();
            $tenants = Tenant::count();
            $tot_transactions = DB::select("SELECT SUM(amount) as total FROM transactions WHERE status = 'Successful'");
            $txn = Transaction::limit('100')->get();
            $sub_group = DB::select("SELECT (SELECT name FROM subscription_plans WHERE uuid = plan_id) as plan, 
              COUNT(plan_id) as count FROM subscriptions GROUP BY plan");
            $data = [
                'users' => $users,
                'landlords' => $landlords,
                'tenants' => $tenants,
                'subscriptions' => $subscriptions,
                'active_subscriptions' => $active_subscriptions,
                'properties' => $properties,
                'transactions' => [
                    'total' => $tot_transactions[0]->total,
                    'list' => $txn
                ],
                'groupings' => $sub_group
            ];

            return view('new.admin_dashboard', compact('data'));
        }
    }
}
