<?php

namespace App\Http\Controllers;

use App\Asset;
use App\Jobs\RentalCreatedEmailJob;
use App\Jobs\RentalUpdatedEmailJob;
use App\Mail\DueRentTenant;
use App\Mail\RentalCreated;
use App\TenantRent;
use Carbon\Carbon;
use DB;
use Illuminate\Http\Request;
use Mail;
use Validator;

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
    

        $validator = Validator::make($request->all(), [
            'tenant' => 'required',
            'property' => 'required',
            'unit' => 'required',
            'price' => 'required|numeric',
            'amount' => 'required|numeric',
            'startDate' => 'required|date_format:"d/m/Y"',
            'due_date' => 'required|date_format:"d/m/Y"'
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)
                        ->withInput()->with('error', 'Please fill in a required fields');
        }

    $data=$request->all();

    $getTenantRents = TenantRent::where('tenant_rents.asset_uuid', $data['property'])
                    ->join('units as a', 'a.uuid', '=', 'tenant_rents.unit_uuid')
                    ->join('tenants as t','t.uuid','=','tenant_rents.tenant_uuid')
                    ->selectRaw('a.*,t.*,tenant_rents.*')
                    ->get();
                            
    if($getTenantRents){
      foreach ($getTenantRents as $key => $tenantRent) {
            if($data['property'] == $tenantRent->asset_uuid 
                && $data['unit'] == $tenantRent->unit_uuid
                && $data['price'] == $tenantRent->price
                && $data['tenant'] == $tenantRent->tenant_uuid)
            {
                 return back()->withInput()->with('error','The selected tentant has already been added to the given property\'s unit ');
            }
      }
    }

    if($request->due_date < $request->startDate){
        return back()->withInput()->with('error','End Date cannot be less than start date');
    }


        DB::beginTransaction();
        try {
            $rental = TenantRent::createNew($request->all());

            RentalCreatedEmailJob::dispatch($rental)
                ->delay(now()->addSeconds(3));

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
                DB::rollback();
                return back()->with('error', 'Oops! An error occured. Please try agian');
            }
            return back()->with('success', 'Rental deleted successfully');
        }
        else{
            return back()->with('error', 'Oops! Could not find rental');
        }
    }

  public  function edit($uuid) {
         $tenantRent = TenantRent::where('uuid',$uuid)
       ->where('user_id',getOwnerUserID())->first();

        $plan = getUserPlan();
        $limit = $plan['details']->properties;
        $limit = $limit == "Unlimited" ? '9999999999999' : $limit;
        $properties = Asset::select('assets.uuid','assets.id','assets.address', 'assets.description',
            'assets.price')
        ->where('assets.user_id', getOwnerUserID())->limit($limit)->get();

        return view('new.admin.rental.edit', compact('tenantRent','properties'));
    }

public function update(Request $request){
              $data = $request->all();
     $validator = Validator::make($data, [
            'tenant_uuid' => 'required',
            'asset_uuid' => 'required',
            'unit_uuid' => 'required',
            'tenantRent_uuid'=>'required',
            'actual_amount' => 'required|numeric',
            'startDate' => 'required|date_format:"d/m/Y"',
            'due_date' => 'required|date_format:"d/m/Y"'
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)
                        ->withInput()->with('error', 'Please fill in a required fields');
        }

          DB::beginTransaction();
            try{
               $rental = TenantRent::editTenantRent($request->all());

            RentalUpdatedEmailJob::dispatch($rental)
                ->delay(now()->addSeconds(3));

                DB::commit();
            }
            catch(\Exception $e)
            {
                DB::rollback();
                return back()->with('error', 'Oops! An error occured. Please try agian');
            }

     
        return redirect()->route('rental.index')->with('success', 'Rental updated successfully');
}

public function yesRenewRent($uuid){
  $renewThisRental = TenantRent::where('uuid',$uuid)
   ->where('user_id',getOwnerUserID())->first();
   if($renewThisRental){
    $renewThisRental->renewable = 'yes';
    $renewThisRental->save();
   }

   return redirect()->route('rental.index')->with('success', 'This rent will be renewed once it expired');
}

public function noRenewRent($uuid){
  $renewThisRental = TenantRent::where('uuid',$uuid)
   ->where('user_id',getOwnerUserID())->first();
   if($renewThisRental){
    $renewThisRental->renewable = 'no';
    $renewThisRental->save();
   }

   return redirect()->route('rental.index')->with('error', 'This rent will not be renewed once it expired');
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

