<?php

namespace App\Http\Controllers;

use App\Asset;
use App\Landlord;
use App\Tenant;
use App\TenantRent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MultiStepFormController extends Controller
{
    public function multiStepOneStoreLandlord(Request $request)
    {

    $rentalsDueInNextThreeMonths = TenantRent::where('tenant_rents.user_id', getOwnerUserID())
                ->whereRaw("due_date BETWEEN CURDATE() AND DATE_ADD(CURDATE(), INTERVAL 120 DAY)")// Get payments due in next 120 days
                ->orderBy('tenant_rents.id', 'desc')->select('tenant_rents.*',DB::raw('TIMESTAMPDIFF(DAY,CURDATE(),tenant_rents.due_date) AS remaingdays'))->get();

    	$renewedRentals = TenantRent::where('tenant_rents.user_id', getOwnerUserID())
                ->where('new_rental_status','New')
                ->orderBy('tenant_rents.id', 'desc')->select('tenant_rents.*')->get();
    	$next_step_asset = '';

    	$landlord = Landlord::createNew($request->all());

    	if($landlord){

     return view('new.dashboard',compact('rentalsDueInNextThreeMonths','renewedRentals','landlord','next_step_asset'));

    }else{
     return view('new.dashboard',compact('rentalsDueInNextThreeMonths','renewedRentals','next_step_asset'));
    }
  }

    public function multiStepTwoStoreAsset(Request $request)
    {

    $rentalsDueInNextThreeMonths = TenantRent::where('tenant_rents.user_id', getOwnerUserID())
                ->whereRaw("due_date BETWEEN CURDATE() AND DATE_ADD(CURDATE(), INTERVAL 120 DAY)")// Get payments due in next 120 days
                ->orderBy('tenant_rents.id', 'desc')->select('tenant_rents.*',DB::raw('TIMESTAMPDIFF(DAY,CURDATE(),tenant_rents.due_date) AS remaingdays'))->get();

    	$renewedRentals = TenantRent::where('tenant_rents.user_id', getOwnerUserID())
                ->where('new_rental_status','New')
                ->orderBy('tenant_rents.id', 'desc')->select('tenant_rents.*')->get();
    	$next_step_tenant = '';

    	$asset = Asset::createNew($request->all());

    	if($asset){
    	session(['asset_key' => $asset]);
     return view('new.dashboard',compact('rentalsDueInNextThreeMonths','renewedRentals','asset','next_step_tenant'));

    }else{
     return view('new.dashboard',compact('rentalsDueInNextThreeMonths','renewedRentals','next_step_asset'));
    }
  }

   public function multiStepThreeStoreTenant(Request $request)
    {

    $rentalsDueInNextThreeMonths = TenantRent::where('tenant_rents.user_id', getOwnerUserID())
                ->whereRaw("due_date BETWEEN CURDATE() AND DATE_ADD(CURDATE(), INTERVAL 120 DAY)")// Get payments due in next 120 days
                ->orderBy('tenant_rents.id', 'desc')->select('tenant_rents.*',DB::raw('TIMESTAMPDIFF(DAY,CURDATE(),tenant_rents.due_date) AS remaingdays'))->get();

    	$renewedRentals = TenantRent::where('tenant_rents.user_id', getOwnerUserID())
                ->where('new_rental_status','New')
                ->orderBy('tenant_rents.id', 'desc')->select('tenant_rents.*')->get();
    	$next_step_rental = '';

    	$tenant = Tenant::createNew($request->all());
    	session(['tenant_key' => $tenant]);

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

    }else{
     return view('new.dashboard',compact('rentalsDueInNextThreeMonths','renewedRentals','next_step_asset'));
    }
  }


}
