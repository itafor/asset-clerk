<?php

namespace App\Http\Controllers;

use App\Asset;
use App\Jobs\DueRentInNext30DaysNotificationJob;
use App\Jobs\DueRentInNext90DaysNotificationJob;
use App\Jobs\NotifyDueRentJob;
use App\Jobs\NotifyFinalDueRentJob;
use App\Jobs\PastDueRentNotificationJob;
use App\Jobs\PlanUpgradeNotificationJob;
use App\Jobs\RentalCreatedEmailJob;
use App\Jobs\RentalRenewedEmailJob;
use App\Jobs\RentalUpdatedEmailJob;
use App\Mail\DueRentTenant;
use App\Mail\RentalCreated;
use App\ReportObjects\DueRentNotification;
use App\Subscription;
use App\TenantRent;
use App\User;
use Carbon\Carbon;
use DB;
use Illuminate\Http\Request;
use Mail;
use Validator;
use DateTime;
use DateInterval;

class RentalController extends Controller
{
    public function index()
    {
        $rentals = TenantRent::where('user_id', getOwnerUserID())
                ->whereNotNull('startDate')
                ->whereNotNull('due_date')
                ->whereNotNull('amount')
        ->orderBy('id', 'desc')->get();

        return view('new.admin.rental.index', compact('rentals'));
    }

     public function displayAllocton()
    {
        $rentals = TenantRent::where('user_id', getOwnerUserID())
                ->where('startDate',null)
                ->where('due_date',null)
                ->where('amount',null)
        ->orderBy('id', 'desc')->get();

        return view('new.admin.rental.partials.list_allocation', compact('rentals'));
    }
    
    
    public function myRentals()
    {
        $rentals = TenantRent::join('tenants as t', 't.uuid', '=', 'tenant_rents.tenant_uuid')
        ->where('t.email', auth()->user()->email)
        ->orderBy('tenant_rents.id', 'desc')->select('tenant_rents.*')->get();
        return view('new.admin.rental.my', compact('rentals'));
    }

     public function addRental($uuid)
    {
         $data['tenantRent'] = TenantRent::where('uuid',$uuid)
       ->where('user_id',getOwnerUserID())->first();

        return view('new.admin.rental.partials.add_rental',$data);
    }

     public function saveRental(Request $request)
    {
        $data=$request->all();

        $startDate = formatDate($data['startDate'], 'd/m/Y', 'Y-m-d');
        $startDate = Carbon::parse($startDate);
        $dueDate = formatDate($data['due_date'], 'd/m/Y', 'Y-m-d');
        $dueDate = Carbon::parse($dueDate);
           

        $duration = $startDate->diff($dueDate)->days;
        $end_date = (new $startDate)->add(new DateInterval("P{$duration}D") );
        $dd = date_diff($startDate,$end_date);
        $final_duration = $dd->y." years, ".$dd->m." months, ".$dd->d." days";

        date_default_timezone_set("Africa/Lagos");
    $startdate = Carbon::parse(formatDate($request->startDate, 'd/m/Y', 'Y-m-d'));
    $enddate   =   Carbon::parse(formatDate($request->due_date, 'd/m/Y', 'Y-m-d'));

    if($enddate < $startdate){
        return back()->withInput()->with('error','End Date cannot be less than start date');
    }
        

     $rental =  tenantRent::where('uuid', $data['tenantRent_uuid'])
                ->where('tenant_uuid', $data['tenant_uuid'])
                ->where('user_id', getOwnerUserID())->first();
        
if($rental){
    $rental->amount = $data['actual_amount'];
    $rental->startDate = $startDate;
    $rental->due_date = $dueDate;
    $rental->new_rental_status = null;
    $rental->duration = $final_duration;//star date
    $rental->renewable = 'yes';
    $rental->status = 'pending';
   if($rental->save()){

    RentalCreatedEmailJob::dispatch($rental)
                ->delay(now()->addSeconds(3));

     return back()->with('success', 'Rental added successfully');
   }
}
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
            'main_unit' => 'required',
            'sub_unit' => 'required',
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
                     ->where('flat_number',$data['sub_unit'])
                     ->where('unit_uuid',$data['main_unit'])
                    ->get();
                            
    if(count($getTenantRents) >=1){
                 return back()->withInput()->with('error','The selected unit has already been assigned');
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
            // 'unit_uuid' => 'required',
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
     * Cron Job for rent due
     * Send landlord list of due rents
     * Send tentant due rent
     *60% renew, 50%,      25%,      13%,      0% cron job
     * @return void
     */
public function notifyDueRentAt50Percent()
    {

       DueRentNotification::DueRentNotificationAt50Percent();

  return 'Done';
}

public function notifyDueRentAt25Percent()
    {
  DueRentNotification::DueRentNotificationAt25Percent();
  return 'Done';
}

public function notifyDueRentAt13Percent()
    {
    DueRentNotification::DueRentNotificationAt13Percent();
  return 'Done';
}

public function notifyDueRentAt0Percent()
    {
    DueRentNotification::DueRentNotificationAt0Percent();
  return 'Done';
}

//rene
 public function renewRentalsAt60Percent(){
        $newRentals = TenantRent::where('renewable', 'yes')
        ->whereRaw('TIMESTAMPDIFF(DAY, CURDATE(),tenant_rents.due_date ) = ROUND(ABS(TIMESTAMPDIFF(DAY, tenant_rents.startDate,tenant_rents.due_date ) * (60/100) ),0)')->with(['users'])
         ->select('tenant_rents.*', DB::raw('TIMESTAMPDIFF(DAY,CURDATE(),tenant_rents.due_date) AS remaingdays'))
        ->get();
//dd($newRentals);
        if($newRentals){
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
                if($rentalsDueInNext90Days){
                foreach ($rentalsDueInNext90Days as $key => $due_rent) {
                    $the_users[] =$due_rent->users;
                }
        $all_users = array_unique($the_users);

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
}

    public function dueRentInNext30DaysNotification(){
    $rentalsDueInNext30Days = TenantRent::whereRaw("due_date BETWEEN CURDATE() AND DATE_ADD(CURDATE(), INTERVAL 30 DAY)")->with(['users'])
                ->orderBy('tenant_rents.id', 'desc')->select('tenant_rents.*',DB::raw('TIMESTAMPDIFF(DAY,CURDATE(),tenant_rents.due_date) AS remaingdays'))->get();
                $the_users=[];
                if($rentalsDueInNext30Days){
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
}

      public function pastDueRentsNotification(){
    $past_due_rents = TenantRent::whereRaw("due_date < CURDATE()")->with(['users'])
                ->orderBy('tenant_rents.id', 'desc')->select('tenant_rents.*',DB::raw('TIMESTAMPDIFF(DAY,CURDATE(),tenant_rents.due_date) AS remaingdays'))->get();
                $the_users=[];
                if($past_due_rents){
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

}

