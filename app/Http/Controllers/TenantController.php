<?php

namespace App\Http\Controllers;

use App\Asset;
use App\Tenant;
use App\TenantRent;
use App\TenantServiceCharge;
use App\Unit;
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

   public function  tenantProfile($id){
     $tenantId = Crypt::decrypt($id);
     
         $tenantDetail = Tenant::where('tenants.id', $tenantId)
            ->join('countries as co','co.id','=','tenants.country_id')
            ->join('states as st','st.id','=','tenants.state_id')
            ->join('cities as c','c.id','=','tenants.city_id')
            ->select('tenants.*','co.name as countryName','st.name as stateName','c.name as cityName')
            ->first();

$tenantsAssignedScs = TenantServiceCharge::where('tenant_service_charges.tenant_id',$tenantId)
         ->where('tenant_service_charges.user_id', getOwnerUserID())
          ->join('asset_service_charges', 'asset_service_charges.id', '=', 'tenant_service_charges.asc_id')
          ->join('tenants','tenants.id','=','tenant_service_charges.tenant_id')
          ->join('service_charges','service_charges.id','=','tenant_service_charges.service_chargeId')
           ->join('assets','assets.id','=','asset_service_charges.asset_id')
         ->select(DB::raw("SUM(tenant_service_charges.bal) as totalDebt"),'tenant_service_charges.*','asset_service_charges.*','tenants.*','service_charges.*','assets.description as assetName')
          ->groupBy('tenant_service_charges.tenant_id')
         ->get();
         dd($tenantsAssignedScs);

        if($tenantDetail){
            return view('new.admin.tenant.tenantProfile.tenant_info',compact('tenantDetail','tenantId','tenantsAssignedScs'));
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
}
