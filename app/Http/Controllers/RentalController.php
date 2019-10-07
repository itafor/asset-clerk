<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use DB;
use App\TenantRent;
use Mail;
use App\Mail\RentalCreated;
use App\Mail\DueRentTenant;

class RentalController extends Controller
{
    public function index()
    {
        $rentals = TenantRent::where('user_id', getOwnerUserID())
        ->orderBy('id', 'desc')->get();
        return view('new.admin.rental.index', compact('rentals'));
    }
    
    public function myRentals()
    {
        $rentals = TenantRent::join('tenants as t', 't.uuid', '=', 'tenant_rents.tenant_uuid')
        ->where('t.email', auth()->user()->email)
        ->orderBy('tenant_rents.id', 'desc')->select('tenant_rents.*')->get();
        return view('new.admin.rental.my', compact('rentals'));
    }

    public function create()
    {
        return view('new.admin.rental.create');
    }

    public function store(Request $request)
    {

            if($request->due_date < $request->startDate){
                return back()->withInput()->with('error','End Date cannot be less than start date');
            }

        $validator = Validator::make($request->all(), [
            'tenant' => 'required',
            'property' => 'required',
            'unit' => 'required',
            'price' => 'required|numeric',
            'startDate' => 'required|date_format:"d/m/Y"',
            'due_date' => 'required|date_format:"d/m/Y"'
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)
                        ->withInput()->with('error', 'Please fill in a required fields');
        }

        DB::beginTransaction();
        try {
            $rental = TenantRent::createNew($request->all());
            $toEmail = $rental->tenant->email;
            Mail::to($toEmail)->send(new RentalCreated($rental));
            DB::commit();
        } catch (Exception $e) {
            DB::rollback();
            return back()->with('error', 'Whoops! An error occured. Please try again.');
        }

        return redirect()->route('rental.index')->with('success', 'Rental logged successfully');
    }

    public function delete($uuid)
    {
        $tenant = TenantRent::where('uuid', $uuid)->first();
        if($tenant){
            DB::beginTransaction();
            try{
                $tenant->removeRental();
                DB::commit();
            }
            catch(\Exception $e)
            {
                DB::rolback();
                return back()->with('error', 'Oops! An error occured. Please try agian');
            }
            return back()->with('success', 'Rental deleted successfully');
        }
        else{
            return back()->with('error', 'Oops! Could not find rental');
        }
    }

    public function approvals()
    {
        return view('admin.rental.approvals');
    }

    /**
     * Cron Job for rent due in 30 Days
     * Send landlord list of due rents
     * Send tentant due rent
     *
     * @return void
     */
    public function notifyDueRent()
    {
        $dueRentals = TenantRent::join('rent_dues as rd', 'rd.rent_id', '=', 'tenant_rents.id')
        ->where('rd.status', 'pending')
        ->whereRaw("DATE_ADD(CURDATE(), INTERVAL 30 DAY) = rd.due_date") 
        ->orderBy('tenant_rents.id', 'desc')->select('tenant_rents.*')->get();

        foreach($dueRentals as $rental) {
            $toEmail = $rental->tenant->email;
            Mail::to($toEmail)->send(new DueRentTenant($rental));
        }

        return 'done';
    }
}
