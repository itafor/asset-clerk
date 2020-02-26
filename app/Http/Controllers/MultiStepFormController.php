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

class MultiStepFormController extends Controller
{

// public $landlordRecord ='';
// public $assetRecord = '';
// public $tenantRecord = '';
// public $rentalRecord = '';
// public $paymentRecord ='';

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
        //Alert::success('Success Title', 'Success Message');

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
             return view('new.dashboard',compact('rentalsDueInNextThreeMonths','renewedRentals','next_step_rental',));
         }else{ 


    	$tenant = Tenant::createNew($request->all());
    	session(['tenant_key' => $tenant]);
      session(['tenantRecord' => $tenant]);

    	if($tenant){
     $asset_value = $request->session()->pull('asset_key', 'default');
     $tenant_value = $request->session()->pull('tenant_key', 'default');

     
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


      $payment = RentPayment::createNew($request->all());
              $toEmail = $payment->get_tenant->email;
            Mail::to($toEmail)->send(new PaymentCreated($payment));
          if($payment){
      session(['paymentRecord' => $payment]);
     return view('new.dashboard',compact('rentalsDueInNextThreeMonths','renewedRentals','next_step_rental_summary','landlord_record','asset_record','tenant_record','rental_record','payment'));
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

     return view('new.dashboard',compact('rentalsDueInNextThreeMonths','renewedRentals','next_step_rental_summary','landlord_record','asset_record','tenant_record','rental_record','payment_record'));
    
}

  public function done(Request $request)
  {

   $rentals = TenantRent::where('user_id', getOwnerUserID())
        ->orderBy('id', 'desc')->get();
        return view('new.admin.rental.index', compact('rentals'));
  }

}
