<?php

namespace App\Http\Controllers;

use App\Asset;
use App\RentDebtor;
use App\RentPayment;
use App\ServiceChargePaymentHistory;
use App\Tenant;
use App\TenantRent;
use App\TenantServiceCharge;
use App\Unit;
use App\Wallet;
use App\WalletHistory;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Validator;

class TenantController extends Controller
{
    public function index()
    {
        $tenants = Tenant::where('user_id', getOwnerUserID())
        ->orderBy('firstname')->get();
        return view('new.admin.tenant.index', compact('tenants'));
    }

    public function create()
    {
        return view('new.admin.tenant.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'designation' => 'required',
            'gender' => 'required',
            'firstname' => 'required',
            'lastname' => 'required',
            'date_of_birth' => 'required|date_format:"d/m/Y"',
            'occupation' => 'required',
            'office_country' => 'required',
            'office_state' => 'required',
            'office_city' => 'required',
            'country' => 'required',
            'state' => 'required',
            'city' => 'required',
            'address' => 'required',
            'email' => 'required|email',
            'contact_number' => 'required',
            'passport' => 'required|image'
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)
                        ->withInput()->with('error', 'Please fill in a required fields');
        }

        try{
            Tenant::createNew($request->all());
        }
        catch(\Exception $e)
        {
            return back()->withInput()->with('error', 'Oops! An error occured.'.$e->getMessage());
        }

        return redirect()->route('tenant.index')->with('success', 'Tenant added successfully');
    }

    public function delete($uuid)
    {
        $tenant = Tenant::where('uuid', $uuid)->first();
        if($tenant){
            $tenant->delete();
            return back()->with('success', 'Tenant deleted successfully');
        }
        else{
            return back()->with('error', 'Whoops! Could not find tenant');
        }
    }

    /**
     * Edit tenant
     */
    public function edit($uuid)
    {
        $tenant = Tenant::where('uuid', $uuid)->first();
        if($tenant){
            return view('new.admin.tenant.edit', compact('tenant'));
        }
        else{
            return back()->with('error', 'Whoops! Could not find tenant');
        }
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'designation' => 'required',
            'gender' => 'required',
            'firstname' => 'required',
            'lastname' => 'required',
            'date_of_birth' => 'required|date_format:"d/m/Y"',
            'occupation' => 'required',
            'office_country' => 'required',
            'office_state' => 'required',
            'office_city' => 'required',
            'country' => 'required',
            'state' => 'required',
            'city' => 'required',
            'address' => 'required',
            'email' => 'required|email',
            'contact_number' => 'required',
            'passport' => 'image',
            'uuid' => 'required'
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)
                        ->withInput()->with('error', 'Please fill in a required fields');
        }

        Tenant::updateTenant($request->all());
        return redirect()->route('tenant.index')->with('success', 'Tenant updated successfully');
    }

      public function fetchTeanatThatBelongsToAnAsset($id)
    {
        $property = Asset::where('id', $id)->where('user_id', getOwnerUserID())->first();
        if($property){

            $units = Unit::where('units.asset_id', $property->id)
            ->join('categories as c', 'c.id', '=', 'units.category_id')
            ->join('tenant_rents as tr', 'tr.unit_uuid', '=', 'units.uuid')
            ->join('tenants as t', 't.uuid', '=', 'tr.tenant_uuid')
            ->selectRaw('units.*, c.name, CONCAT(t.designation, " ", t.firstname, " ", t.lastname) as tenant, t.id as tenantId')
            // ->where('units.quantity_left', '>', 0)
            ->whereNull('tr.deleted_at')
            ->whereRaw('tr.due_date > CURDATE()')
            ->get();
            return response()->json($units);
        }
        else{
            return [];
        }
    }



    public function myProfile()
    {
        return view('admin.tenant.my_profile');
    }

    public function myRent()
    {
        return view('admin.tenant.my_rent');
    }

    public function referals()
    {
        return view('admin.tenant.referals');
    }

    public function myMaintenance()
    {
        return view('admin.tenant.maintenance');
    }

    public function createMaintenance()
    {
        return view('admin.tenant.create_maintenance');
    }

       public function  tenantProfile($id){
     $tenantId = Crypt::decrypt($id);
     
         $tenantDetail = Tenant::where('tenants.id', $tenantId)
            ->join('countries as co','co.id','=','tenants.country_id')
            ->join('states as st','st.id','=','tenants.state_id')
            ->join('cities as c','c.id','=','tenants.city_id')
            ->select('tenants.*','co.name as countryName','st.name as stateName','c.name as cityName')
            ->first();

 $tenantRents  = TenantRent::where('user_id', getOwnerUserID())
                ->whereNull('new_rental_status')
                ->where('tenant_uuid',$tenantDetail->uuid)
                ->orderBy('id', 'desc')->get();

 $tenantRentalPaymentHistories  = RentPayment::where('user_id',getOwnerUserID())
                                ->where('tenant_uuid',$tenantDetail->uuid)->get();

 $tenantRentalDebts = RentDebtor::where('user_id',getOwnerUserID())
                             ->where('tenant_uuid', $tenantDetail->uuid)
                             ->whereNull('new_rental_status')
                             ->whereNull('deleted_at')
                             ->get();


 $tenantRentalTotalDebt = DB::table('rent_debtors')
    ->join('tenants', 'tenants.uuid', '=', 'rent_debtors.tenant_uuid')
    ->where('rent_debtors.tenant_uuid', $tenantDetail->uuid)
     ->whereNull('new_rental_status')
    ->sum('rent_debtors.balance');

  

$tenantsAssignedScs = TenantServiceCharge::join('asset_service_charges', 'asset_service_charges.id', '=', 'tenant_service_charges.asc_id')
          ->join('tenants','tenants.id','=','tenant_service_charges.tenant_id')
          ->join('service_charges','service_charges.id','=','tenant_service_charges.service_chargeId')
           ->join('assets','assets.id','=','asset_service_charges.asset_id')
         ->where('tenant_service_charges.tenant_id',$tenantId)
         ->where('tenant_service_charges.user_id', getOwnerUserID())
         ->select('tenant_service_charges.*','asset_service_charges.*','tenants.*','service_charges.*','assets.description as assetName')
         ->get();

         $tenantTotalDebt = DB::table('tenant_service_charges')
    ->join('tenants', 'tenants.id', '=', 'tenant_service_charges.tenant_id')
    ->where('tenant_service_charges.tenant_id', $tenantId)
    ->sum('tenant_service_charges.bal');

     $tenantSCHs = ServiceChargePaymentHistory::join('tenants','tenants.id','=','service_charge_payment_histories.tenant')
          ->join('service_charges','service_charges.id','=','service_charge_payment_histories.service_charge')
         ->where('service_charge_payment_histories.user_id', getOwnerUserID())
        ->where('service_charge_payment_histories.tenant',$tenantId)
         ->select('service_charge_payment_histories.*',
            DB::raw('CONCAT(tenants.designation, " ", tenants.firstname, " ", tenants.lastname) as tenantDetail'),
            'tenants.*','service_charges.*')
         ->orderby('service_charge_payment_histories.created_at','asc')
         ->get();

    $tenantWalletsHistories = WalletHistory::join('tenants','tenants.id','=','wallet_histories.tenant_id')
    ->where('wallet_histories.user_id',getOwnerUserID())
    ->where('wallet_histories.tenant_id',$tenantId)
    ->select('wallet_histories.*',
            DB::raw('CONCAT(tenants.designation, " ", tenants.firstname, " ", tenants.lastname) as tenantDetail'))
    ->get();

    $tenantWalletBal = Wallet::where('tenant_id',$tenantId)
    ->where('user_id',getOwnerUserID())->first();
   
  
        if($tenantDetail){
            return view('new.admin.tenant.tenantProfile.tenant_info',compact('tenantDetail','tenantId','tenantsAssignedScs','tenantTotalDebt','tenantSCHs','tenantWalletsHistories','tenantWalletBal','tenantRentalPaymentHistories','tenantRentalTotalDebt','tenantRentalDebts','tenantRents'));
        }
    }

public function searchTenantGlobally(Request $request){
     if($request->get('query2'))
     {
      $query2 = $request->get('query2');
      $users = Tenant::where('firstname','like',"%{$query2}%")
      ->orwhere('lastname','like',"%{$query2}%")
      ->orwhere('date_of_birth','like',"%{$query2}%")
      ->orwhere('address','like',"%{$query2}%")
      ->orwhere('state','like',"%{$query2}%")
      ->orwhere('phone','like',"%{$query2}%")
    ->get();
    $output = '<ul class="dropdown-menu" 
    style="display: block; 
    position: absolute; z-index: 1; width:300px; padding-left:20px; margin-left:10px;">';
    foreach ($users as $row) {
       $tenant_id = Crypt::encrypt($row->id);
       if($row){
$output.='<li><a href="/tenant/profile-details/'.$tenant_id.'">'.$row->firstname.'  '.$row->lastname.'</a></li>';
 }else{
    $output.='<li>Nothing found</li>';
 }
    }
   $output .='</ul>';
   echo $output;
    ;
    }
   }

    public function getTenantEmail($tenant_id){
          
          $tenants = Tenant::where('id',$tenant_id)
              ->where('user_id', getOwnerUserID())->first();
         if($tenants){
         return  $tenants;
         }
    }
}
