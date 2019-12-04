<?php

namespace App\Http\Controllers;

use App\Asset;
use App\Jobs\DueRentInNext30DaysNotificationJob;
use App\Jobs\DueRentInNext90DaysNotificationJob;
use App\Jobs\NotifyDueRentJob;
use App\Jobs\PastDueRentNotificationJob;
use App\Jobs\PlanUpgradeNotificationJob;
use App\Jobs\RentalCreatedEmailJob;
use App\Jobs\RentalRenewedEmailJob;
use App\Jobs\RentalUpdatedEmailJob;
use App\Mail\DueRentTenant;
use App\Mail\RentalCreated;
use App\Subscription;
use App\TenantRent;
use App\User;
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
   
    date_default_timezone_set("Africa/Lagos");
    $startdate = Carbon::parse(formatDate($request->startDate, 'd/m/Y', 'Y-m-d'));
    $enddate   =   Carbon::parse(formatDate($request->due_date, 'd/m/Y', 'Y-m-d'));

    if($enddate < $startdate){
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

               TenantRent::rentalDebtorsNewRentalStatusUpdate($request->all());
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
 
 return 'yes';
}

public function noRenewRent($uuid){
  $renewThisRental = TenantRent::where('uuid',$uuid)
   ->where('user_id',getOwnerUserID())->first();
   if($renewThisRental){
    $renewThisRental->renewable = 'no';
    $renewThisRental->save();
   }
return 'no';
}

public function viewDetail($uuid){

    $rental3 = TenantRent::where('uuid',$uuid)
    ->where('user_id',getOwnerUserID())->first();
    return view('new.admin.rental.partials.view_rentals', compact('rental3'));
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
     $dueRentals = TenantRent::where('renewable', 'yes')
         ->select('tenant_rents.*', DB::raw('TIMESTAMPDIFF(DAY,CURDATE(),tenant_rents.due_date) AS remaingdays'))
         ->whereRaw('TIMESTAMPDIFF(DAY, CURDATE(),tenant_rents.due_date ) = ROUND(ABS(TIMESTAMPDIFF(DAY, tenant_rents.startDate,tenant_rents.due_date ) * (11/100) ),0)') 
         ->get();
  //dd($dueRentals);

        foreach($dueRentals as $rental) {
             $renewed_rental = TenantRent::where('previous_rental_id',$rental->id)->first();
             if($renewed_rental){
                 NotifyDueRentJob::dispatch($rental,$renewed_rental)
            ->delay(now()->addSeconds(5));
             }
            
        }

        return 'done';
    }

 public function renewRentals(){
        $newRentals = TenantRent::where('renewable', 'yes')
        ->whereRaw('TIMESTAMPDIFF(DAY, CURDATE(),tenant_rents.due_date ) = ROUND(ABS(TIMESTAMPDIFF(DAY, tenant_rents.startDate,tenant_rents.due_date ) * (11/100) ),0)')->with(['users'])
         ->select('tenant_rents.*', DB::raw('TIMESTAMPDIFF(DAY,CURDATE(),tenant_rents.due_date) AS remaingdays'))
        ->get();
//dd($newRentals);
     foreach($newRentals as $rent) {
    $newRentDetails['tenant']    = $rent->tenant_uuid;
    $newRentDetails['property']  = $rent->asset_uuid;
    $newRentDetails['unit']      = $rent->unit_uuid;
    $newRentDetails['price']     = $rent->price;
    $newRentDetails['amount']    = $rent->amount;
    $newRentDetails['startDate'] = Carbon::now()->format('d/m/Y');
    $newRentDetails['due_date'] = Carbon::now()->addYear()->format('d/m/Y');
    $newRentDetails['user_id']    = $rent->user_id;
    $newRentDetails['new_rental_status'] = 'New';
    $newRentDetails['renewable'] = 'no';
    $newRentDetails['previous_rental_id'] = $rent->id;

            if(!empty($newRentDetails)){

                DB::beginTransaction();
        try {
            $rental = TenantRent::createNew($newRentDetails);

            RentalRenewedEmailJob::dispatch($rental,$rent->users,$rent)
            ->delay(now()->addSeconds(5));
            $this->setRenewableColumnToNo($rental->id,$rental->user_id);     
            DB::commit();

        } catch (Exception $e) {
            DB::rollback();
            return false;
            }

        }
    }
    return 'Done';
    }

    public function setRenewableColumnToNo($id,$user_id){
             $rental =  TenantRent::where('id',$id)
                ->where('user_id', $user_id)->first();
        
if($rental){
    $rental->renewable = 'no';
   $rental->save();
   }
}

public function planUpgradeNotification(){
 
   $free_users =Subscription::join('users','users.id','=','subscriptions.user_id')
                        ->join('subscription_plans as sp','sp.uuid','=','subscriptions.plan_id')
                        ->where('subscriptions.status','Active')
                        ->where('sp.name','Free')
                        ->select('users.*')
                        ->get();
        if (!is_null($free_users)){

            foreach ($free_users as $key => $user) {
               $getUsers=User::where('id',$user->id)->get();
                foreach ($getUsers as $key => $u) {
               PlanUpgradeNotificationJob::dispatch($u)
            ->delay(now()->addSeconds(5));
            }
            }


    }else{
        return null;
    }

  }
 
  public function dueRentInNext90DaysNotification(){
    $rentalsDueInNext90Days = TenantRent::whereRaw("due_date BETWEEN CURDATE() AND DATE_ADD(CURDATE(), INTERVAL 90 DAY)")->with(['users'])
                ->orderBy('tenant_rents.id', 'desc')->select('tenant_rents.*',DB::raw('TIMESTAMPDIFF(DAY,CURDATE(),tenant_rents.due_date) AS remaingdays'))->get();
                $the_users=[];
                foreach ($rentalsDueInNext90Days as $key => $due_rent) {
                    $the_users[] =$due_rent->users;
                }
        $all_users = array_unique($the_users);
                // dd($all_users);

        foreach ($all_users as $key => $user) {
            $userDetail = User::where('id',$user->id)->first();
           $rentalsDueInNext90Days2 = TenantRent::where('tenant_rents.user_id',$user->id)
           ->whereRaw("due_date BETWEEN CURDATE() AND DATE_ADD(CURDATE(), INTERVAL 90 DAY)")
        ->orderBy('tenant_rents.id', 'desc')->select('tenant_rents.*',DB::raw('TIMESTAMPDIFF(DAY,CURDATE(),tenant_rents.due_date) AS remaingdays'))->get();

        $totalRentsNotPaid = DB::table('tenant_rents')
    ->where('user_id',$user->id)
    ->whereRaw("due_date BETWEEN CURDATE() AND DATE_ADD(CURDATE(), INTERVAL 90 DAY)")
    ->sum('tenant_rents.balance');

DueRentInNext90DaysNotificationJob::dispatch($userDetail,$rentalsDueInNext90Days2,$totalRentsNotPaid)
    ->delay(now()->addSeconds(5));
        }
return 'Done';
  }

    public function dueRentInNext30DaysNotification(){
    $rentalsDueInNext30Days = TenantRent::whereRaw("due_date BETWEEN CURDATE() AND DATE_ADD(CURDATE(), INTERVAL 30 DAY)")->with(['users'])
                ->orderBy('tenant_rents.id', 'desc')->select('tenant_rents.*',DB::raw('TIMESTAMPDIFF(DAY,CURDATE(),tenant_rents.due_date) AS remaingdays'))->get();
                $the_users=[];
                foreach ($rentalsDueInNext30Days as $key => $due_rent) {
                    $the_users[] =$due_rent->users;
                }
        $all_users = array_unique($the_users);

        foreach ($all_users as $key => $user) {
            $userDetail = User::where('id',$user->id)->first();
           $rentalsDueInNext30Days2 = TenantRent::where('tenant_rents.user_id',$user->id)
           ->whereRaw("due_date BETWEEN CURDATE() AND DATE_ADD(CURDATE(), INTERVAL 30 DAY)")
        ->orderBy('tenant_rents.id', 'desc')->select('tenant_rents.*',DB::raw('TIMESTAMPDIFF(DAY,CURDATE(),tenant_rents.due_date) AS remaingdays'))->get();

        $totalRentsNotPaid = DB::table('tenant_rents')
    ->where('user_id',$user->id)
    ->whereRaw("due_date BETWEEN CURDATE() AND DATE_ADD(CURDATE(), INTERVAL 30 DAY)")
    ->sum('tenant_rents.balance');

DueRentInNext30DaysNotificationJob::dispatch($userDetail,$rentalsDueInNext30Days2,$totalRentsNotPaid)
    ->delay(now()->addSeconds(5));
        }
return 'Done';
  }

      public function pastDueRentsNotification(){
    $past_due_rents = TenantRent::whereRaw("due_date < CURDATE()")->with(['users'])
                ->orderBy('tenant_rents.id', 'desc')->select('tenant_rents.*',DB::raw('TIMESTAMPDIFF(DAY,CURDATE(),tenant_rents.due_date) AS remaingdays'))->get();
                $the_users=[];
                foreach ($past_due_rents as $key => $due_rent) {
                    $the_users[] =$due_rent->users;
                }
        $all_users = array_unique($the_users);

        foreach ($all_users as $key => $user) {
            $userDetail = User::where('id',$user->id)->first();
           $past_due_rents2 = TenantRent::where('tenant_rents.user_id',$user->id)
           ->whereRaw("due_date < CURDATE()")
        ->orderBy('tenant_rents.id', 'desc')->select('tenant_rents.*',DB::raw('TIMESTAMPDIFF(DAY,CURDATE(),tenant_rents.due_date) AS remaingdays'))->get();

        $totalRentsNotPaid = DB::table('tenant_rents')
    ->where('user_id',$user->id)
    ->whereRaw("due_date < CURDATE()")
    ->sum('tenant_rents.balance');
//dd($totalRentsNotPaid);

PastDueRentNotificationJob::dispatch($userDetail,$past_due_rents2,$totalRentsNotPaid)
    ->delay(now()->addSeconds(5));
        }
return 'Done';
  }

 
}

