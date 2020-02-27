<?php

namespace App\Http\Controllers;

use App\Asset;
use App\Jobs\RentalCreatedEmailJob;
use App\Landlord;
use App\Mail\PaymentCreated;
use App\RentPayment;
use App\Tenant;
use App\TenantRent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use RealRashid\SweetAlert\Facades\Alert;
use Session;
use DateTime;

class MultiStepFormController extends Controller
{

public static function getRentals()
{
    $rentalsDueInNextThreeMonths = TenantRent::where('tenant_rents.user_id', getOwnerUserID())
                ->whereRaw("due_date BETWEEN CURDATE() AND DATE_ADD(CURDATE(), INTERVAL 120 DAY)")// Get payments due in next 120 days
                ->orderBy('tenant_rents.id', 'desc')->select('tenant_rents.*',DB::raw('TIMESTAMPDIFF(DAY,CURDATE(),tenant_rents.due_date) AS remaingdays'))->get();

      $renewedRentals = TenantRent::where('tenant_rents.user_id', getOwnerUserID())
                ->where('new_rental_status','New')
                ->orderBy('tenant_rents.id', 'desc')->select('tenant_rents.*')->get();
            return [
              'rentalsDueInNextThreeMonths'=> $rentalsDueInNextThreeMonths,
              'renewedRentals'=> $renewedRentals
            ];
}


    public function multiStepOneStoreLandlord(Request $request)
    {
      
      $data=$request->all();

      $rentalsDueInNextThreeMonths = self::getRentals()['rentalsDueInNextThreeMonths'];
      $renewedRentals = self::getRentals()['renewedRentals'];
  
    	$next_step_asset = '';

      $landlord_exist=Landlord::where('firstname',$data['firstname'])
                              ->where('lastname',$data['lastname'])
                              ->where('email',$data['email'])
                              ->where('phone',$data['contact_number'])->first();
         if($landlord_exist)
         {
             return view('new.dashboard',compact('rentalsDueInNextThreeMonths','renewedRentals','next_step_asset'));
         }else{  

    	$landlord = Landlord::createNew($request->all());

    	if($landlord){
        session(['landlordRecord' => $landlord]);
     return view('new.dashboard',compact('rentalsDueInNextThreeMonths','renewedRentals','landlord','next_step_asset'));

    }
  }
}
    public function multiStepTwoStoreAsset(Request $request)
    {
       $data=$request->all();
      $rentalsDueInNextThreeMonths = self::getRentals()['rentalsDueInNextThreeMonths'];
      $renewedRentals = self::getRentals()['renewedRentals'];    	
      $next_step_tenant = '';

        $asset_exist=Asset::where('description',$data['description'])
                              ->where('country_id',$data['country'])
                              ->where('state_id',$data['state'])
                              ->where('city_id',$data['city'])
                              ->where('property_type',$data['property_type'])
                              ->where('address',$data['address'])
                              ->where('price',$data['asking_price'])
                              ->first();
         if($asset_exist)
         {
             return view('new.dashboard',compact('rentalsDueInNextThreeMonths','renewedRentals','next_step_tenant'));
         }else{
    	$asset = Asset::createNew($request->all());

    	if($asset){
    	session(['asset_key' => $asset]);
      session(['assetRecord' => $asset]);
     return view('new.dashboard',compact('rentalsDueInNextThreeMonths','renewedRentals','asset','next_step_tenant'));
    }
  }
}
   public function multiStepThreeStoreTenant(Request $request)
    {
       $data=$request->all();

     $rentalsDueInNextThreeMonths = self::getRentals()['rentalsDueInNextThreeMonths'];
      $renewedRentals = self::getRentals()['renewedRentals'];
      $next_step_rental = '';

       $tenant_exist=Tenant::where('firstname',$data['firstname'])
                              ->where('lastname',$data['lastname'])
                              ->where('email',$data['email'])
                              ->where('phone',$data['contact_number'])->first();
         if($tenant_exist)
         {
          $asset_value = Session::get('asset_key'); 
          $tenant_value = Session::get('tenant_key');
             return view('new.dashboard',compact('rentalsDueInNextThreeMonths','renewedRentals','next_step_rental','asset_value','tenant_value'));
         }else{ 


    	$tenant = Tenant::createNew($request->all());
    	session(['tenant_key' => $tenant]);
      session(['tenantRecord' => $tenant]);

    	if($tenant){
     $asset_value = Session::get('asset_key'); 
     $tenant_value = Session::get('tenant_key');

     
     $property = $asset_value->uuid;
     $tenant = $tenant_value->uuid;

      $data = [
      	'property'=>$property,
      	'tenant'=>$tenant
      ];

        Tenant::assignTenantToProperty($data);

     return view('new.dashboard',compact('rentalsDueInNextThreeMonths','renewedRentals','next_step_rental','asset_value','tenant_value'));

    }
  }
}

    public function multiStepFourStoreRental(Request $request)
    {
      $data=$request->all();
  $rentalsDueInNextThreeMonths = self::getRentals()['rentalsDueInNextThreeMonths'];
      $renewedRentals = self::getRentals()['renewedRentals'];
            $next_step_rental_payment = '';

          $tenantRent=TenantRent::where('tenant_uuid',$data['tenant'])
                              ->where('asset_uuid',$data['property'])
                              ->where('price',$data['price'])
                              ->where('amount',$data['amount'])->first();
         if($tenantRent)
         {
             return view('new.dashboard',compact('rentalsDueInNextThreeMonths','renewedRentals','next_step_rental_payment','tenantRent'));
         }else{ 

      $tenantRent = TenantRent::createNew($request->all());

            RentalCreatedEmailJob::dispatch($tenantRent)
                ->delay(now()->addSeconds(3));
          if($tenantRent){
      session(['rentalRecord' => $tenantRent]);

     return view('new.dashboard',compact('rentalsDueInNextThreeMonths','renewedRentals','next_step_rental_payment','tenantRent'));
    }
  }
}

public function multiStepFiveStoreRentalPayment(Request $request)
    {
      $data=$request->all();

    $rentalsDueInNextThreeMonths = self::getRentals()['rentalsDueInNextThreeMonths'];
      $renewedRentals = self::getRentals()['renewedRentals'];

      $next_step_rental_summary = '';
     $landlord_record = Session::get('landlordRecord');
     $asset_record = Session::get('assetRecord'); 
     $tenant_record = Session::get('tenantRecord');
     $rental_record = Session::get('rentalRecord');

       $dateOne =self::displayDueRentNotificationDates($rental_record->startDate,$rental_record->due_date)['dateOne'];

       $dateTwo =self::displayDueRentNotificationDates($rental_record->startDate,$rental_record->due_date)['dateTwo'];

       $dateThree =self::displayDueRentNotificationDates($rental_record->startDate,$rental_record->due_date)['dateThree'];

       $datefour =self::displayDueRentNotificationDates($rental_record->startDate,$rental_record->due_date)['datefour'];

      $payment=RentPayment::where('tenant_uuid',$data['tenant_uuid'])
                              ->where('asset_uuid',$data['asset_uuid'])
                              ->where('tenantRent_uuid',$data['tenantRent_uuid'])
                              ->first();
         if($payment)
         {
             return view('new.dashboard',compact('rentalsDueInNextThreeMonths','renewedRentals','next_step_rental_summary','landlord_record','asset_record','tenant_record','rental_record','payment','dateOne','dateTwo','dateThree','datefour'));
         }else{ 

      $payment = RentPayment::createNew($request->all());
              $toEmail = $payment->get_tenant->email;
            Mail::to($toEmail)->send(new PaymentCreated($payment));
          if($payment){
      session(['paymentRecord' => $payment]);
     return view('new.dashboard',compact('rentalsDueInNextThreeMonths','renewedRentals','next_step_rental_summary','landlord_record','asset_record','tenant_record','rental_record','payment','dateOne','dateTwo','dateThree','datefour'));
    }
  
  }
}

public function nextToAsset(Request $request)
{

  $rentalsDueInNextThreeMonths = self::getRentals()['rentalsDueInNextThreeMonths'];
  $renewedRentals = self::getRentals()['renewedRentals'];

      $next_step_asset = '';


     return view('new.dashboard',compact('rentalsDueInNextThreeMonths','renewedRentals','next_step_asset'));
    
 }

 public function backToLandlord(Request $request)
{
     $rentalsDueInNextThreeMonths = self::getRentals()['rentalsDueInNextThreeMonths'];
      $renewedRentals = self::getRentals()['renewedRentals'];

      $next_step_landlord = '';

     return view('new.dashboard',compact('rentalsDueInNextThreeMonths','renewedRentals','next_step_landlord'));
    
}


 public function nextToSummary(Request $request)
{
      $rentalsDueInNextThreeMonths = self::getRentals()['rentalsDueInNextThreeMonths'];
      $renewedRentals = self::getRentals()['renewedRentals'];

     $next_step_rental_summary = '';
     $landlord_record = Session::get('landlordRecord');
     $asset_record = Session::get('assetRecord'); 
     $tenant_record = Session::get('tenantRecord');
     $rental_record = Session::get('rentalRecord');
     $payment_record = $request->session()->pull('paymentRecord', 'default');

      $dateOne =self::displayDueRentNotificationDates($rental_record->startDate,$rental_record->due_date)['dateOne'];

      $dateTwo =self::displayDueRentNotificationDates($rental_record->startDate,$rental_record->due_date)['dateTwo'];

     $dateThree =self::displayDueRentNotificationDates($rental_record->startDate,$rental_record->due_date)['dateThree'];

     $datefour =self::displayDueRentNotificationDates($rental_record->startDate,$rental_record->due_date)['datefour'];


     return view('new.dashboard',compact('rentalsDueInNextThreeMonths','renewedRentals','next_step_rental_summary','landlord_record','asset_record','tenant_record','rental_record','payment_record','dateOne','dateTwo','dateThree','datefour'));
    
}

  public function done(Request $request)
  {

   $rentals = TenantRent::where('user_id', getOwnerUserID())
        ->orderBy('id', 'desc')->get();
        return view('new.admin.rental.index', compact('rentals'));
  }

  public static function displayDueRentNotificationDates($startDate,$dueDate)
    {
        $start_date = new DateTime($startDate);
        $due_date = new DateTime($dueDate);
        $days  = $due_date->diff($start_date)->format('%a');

        $fifty_percent = round(50/100 * $days,0);
        $dateOne = date('Y-m-d', strtotime($start_date->format('Y-m-d'). ' + '.$fifty_percent.' days')); 

        $seventy_five_percent = round(75/100 * $days,0);
        $dateTwo = date('Y-m-d', strtotime($start_date->format('Y-m-d'). ' + '.$seventy_five_percent.' days')); 

        $eighty_eight_percent = round(88/100 * $days,0);
        $dateThree = date('Y-m-d', strtotime($start_date->format('Y-m-d'). ' + '.$eighty_eight_percent.' days')); 

        $hundred_percent = round(100/100 * $days,0);
        $datefour = date('Y-m-d', strtotime($start_date->format('Y-m-d'). ' + '.$hundred_percent.' days')); 

        return [
            'dateOne'=>$dateOne,
            'dateTwo'=>$dateTwo,
            'dateThree'=>$dateThree,
            'datefour'=>$datefour,
        ];

        //40% renew, 50%, 50+25=75%, 75+13=88%, 88+12=100%
        //60% renew, 50%,      25%,      13%,      0% cron job
    }

}
