<?php

namespace App\Http\Controllers;

use App\Asset;
use App\AssetPhoto;
use App\AssetServiceCharge;
use App\AssignedAsset;
use App\Tenant;
use App\TenantServiceCharge;
use App\Unit;
use Carbon\Carbon;
use DB;
use Illuminate\Http\Request;
use Validator;
use DateTime;

class AssetController extends Controller
{
    public function index(Request $request)
    {
        $plan = getUserPlan();

        $limit = $plan['details']->properties;
        $limit = $limit == "Unlimited" ? '9999999999999' : $limit;
        $query = Asset::query()
        ->select('assets.uuid','assets.id','assets.address', 'assets.description',
            'assets.price')
        ->where('assets.user_id', getOwnerUserID())->limit($limit);

        $data = [
            'assetsCategories' => $query->orderBy('assets.id', 'desc')->get(),
            'term' => ''
        ];

        return view('new.admin.assets.index', $data);
    }

    public function create()
    {
        $charges = AssetServiceCharge::join('assets', 'asset_service_charges.asset_id', '=', 'assets.id')
         ->where('assets.user_id', getOwnerUserID())
         ->where('status', 1)
         ->with('asset')
         ->select('asset_service_charges.*')
         ->get();

        chekUserPlan('property');
        return view('new.admin.assets.create', compact('charges'));
    }

    public function store(Request $request)
    {

      if(!$this->checkAvailableSlot($request)){
            return back()->withInput()->with('error','You have only ' . getSlots()['availableSlots'] . ' slot left, upgrade to add more assets');
            }

        chekUserPlan('property');
        $validator = Validator::make($request->all(), [
            'description' => 'required',
            'unit.*.category' => 'required',
            'unit.*.quantity' => 'required',
            'unit.*.standard_price' => 'required',
            'unit.*.property_type' => 'required',
            'unit.*.apartment_type' => 'required',
            'unit.*.rent_commission' => 'required',
            'landlord' => 'required',
            'country' => 'required',
            'state' => 'required',
            'city' => 'required',
            'address' => 'required',
            'detailed_information' => 'required',
            'features.*' => 'required',
            'photos.*' => 'image',
            // 'commission' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)
                        ->withInput()->with('error', 'Please fill in a required fields');
        }

        DB::beginTransaction();
        try{
            Asset::createNew($request->all());
            DB::commit();
        }
        catch(Exception $e){
            DB::rollback();
            return back()->withInput()->with('error', 'An error occured. Please try again');
        }
        return redirect()->route('asset.index')->with('success', 'Asset added successfully');
    }

    public function edit($uuid)
    {
        $asset = Asset::where('uuid', $uuid)->with('units')->first();
        if($asset){
            return view('new.admin.assets.edit', compact('asset'));
        }
        else{
            return back()->with('error', 'Whoops! Could not find asset');
        }
    }

    public function update(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'description' => 'required',
            // 'commission' => 'required|numeric',
            'landlord' => 'required',
            'country' => 'required',
            'state' => 'required',
            'city' => 'required',
            'address' => 'required',
            'detailed_information' => 'required',
            'features.*' => 'required',
            'uuid' => 'required',
            'unit.*.category' => 'required',
            // 'unit.*.quantity' => 'required',
            'unit.*.standard_price' => 'required',
            'unit.*.property_type' => 'required',
            'photos.*' => 'image',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)
                        ->withInput()->with('error', 'Please fill in a required fields');
        }

        DB::beginTransaction();

        try{
            Asset::updateAsset($request->all());
            DB::commit();
        }
        catch(Exception $e){
            DB::rollback();
            return back()->withInput()->with('error', 'An error occured. Please try again');
        }

        return redirect()->route('asset.index')->with('success', 'Asset updated successfully');
    }

    public function delete($uuid)
    {
        $asset = Asset::where('uuid', $uuid)->first();
        if($asset){
            $asset->delete();
            return back()->with('success', 'Asset deleted successfully');
        }
        else{
            return back()->with('error', 'Whoops! Could not find asset');
        }
    }

    public function deleteImage($id)
    {
        $photo = AssetPhoto::find($id);
        if($photo){
            $photo->delete();
            return back()->with('success', 'Photo deleted successfully');
        }
        else{
            return back()->with('error', 'Photo not found. Please try again');
        }
    }
    
    public function deleteUnit($id)
    {
        $unit = Unit::find($id);
        if($unit){
            if($unit->isRented()){
                return back()->with('error', 'This unit has already been rented');
            }
            $unit->delete();
            return back()->with('success', 'Unit deleted successfully');
        }
        else{
            $unit = Unit::where('uuid',$id)->first();
            if($unit){
                if($unit->isRented()){
                    return back()->with('error', 'This unit has already been rented');
                }
                $unit->delete();
                return back()->with('success', 'Unit deleted successfully');
            } else{
                return back()->with('error', 'Unit not found. Please try again');
            }
        }
    }
    
    public function deleteService($id)
    {
        $sc = AssetServiceCharge::find($id);
        if($sc){
            $sc->status = 0;
            $sc->save();

            $deleteTenantsfromSC = TenantServiceCharge::where('asc_id',$id)
            ->where('user_id',getOwnerUserID())->get();
         
          if($deleteTenantsfromSC){
            foreach ($deleteTenantsfromSC as $key => $value) {
                $value->delete();
            }
          }

            return back()->with('success', 'Service charge deleted successfully');
        }
        else{
            return back()->with('error', 'Service charge not found. Please try again');
        }
    }

    public function assign(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'asset' => 'required',
            'user' => 'required',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)
                        ->withInput()->with('error', 'Please select a user');
        }

        $exists = AssignedAsset::where([
            ['asset_id', $request['asset']],
            ['user_id', $request['user']],
        ])->first();

        if($exists){
            return back()->with('error', 'Asset has already been assigned to this user');
        }
        else{
            $aa = new AssignedAsset;
            $aa->asset_id = $request['asset'];
            $aa->user_id = $request['user'];
            $aa->save();
        }
        return back()->with('success', 'Asset has been assigned to user successfully');
    }

    public function myAssets(Request $request)
    {
        $query = AssignedAsset::where('user_id', getOwnerUserID())
        ->orderBy('id', 'desc')->with('asset.units')->get();
        
        $data = [
            'assets' => $query,
            'term' => ''
        ];
        return view('new.admin.assets.my', $data);
    }

    public function createServiceCharge(Request $request){
        return view('new.admin.assets.create_asset_service_charge');
    }

      public static function array_has_dupes($array) {
      return count($array) !== count(array_unique($array));//check if array has duplicates
}


    public function add_Service_Charge(Request $request)
    {
         $services = $request->service;
         $tenantIds= $request->tenant_id;
        $validator = Validator::make($request->all(), [
            'service.*.type' => 'required',
            'service.*.service_charge' => 'required',
            'service.*.price' => 'required',
            'dueDate' => 'required',
            'startDate' => 'required',
            'asset' => 'required',
            'tenant_id' => 'required',
        ]);
        if ($validator->fails()) {
            return back()->withErrors($validator)
                        ->withInput()->with('error', 'Please fill in a required fields');
        }

    date_default_timezone_set("Africa/Lagos");
    $startdate = Carbon::parse(formatDate($request->startDate, 'd/m/Y', 'Y-m-d'));
    $enddate   = Carbon::parse(formatDate($request->dueDate, 'd/m/Y', 'Y-m-d'));

    if($enddate < $startdate){
        return back()->withInput()->with('error','End Date cannot be less than start date');
    }

        $service_charges = [];
        foreach ($services as $key => $value) {
           $service_charges[]=$value['service_charge'];
        }

        $dup = self::array_has_dupes($service_charges);

        if($dup){
         return back()->withInput()->with('error','Duplicate service charges detected, Check and try again!!');
        }

     foreach ($services as $key => $value) {
          if($value['service_charge'] ==='12' && $value['description'] === null){
                return back()->withInput()->with('error','please provide description for the selected Other option');
          }else if($value['service_charge'] ==='13' && $value['description'] === null){
                 return back()->withInput()->with('error','please provide description for the selected Other option');
          }
        }
   
$allTenantServiceCharges=TenantServiceCharge::where('user_id',getOwnerUserID())->get();
        
       if($allTenantServiceCharges){
            foreach ($allTenantServiceCharges as $key => $aTSC) {
                foreach ($services as $key => $service) {
                    foreach ($tenantIds as $key => $tenantId) {

                    if(
                            $tenantId == $aTSC->tenant_id
                        &&  $service['service_charge'] == $aTSC->service_chargeId
                        &&  $request->startDate == Carbon::parse($aTSC->startDate)->format('d/m/Y')
                         &&  $request->dueDate == Carbon::parse($aTSC->dueDate)->format('d/m/Y')
                    ){
                         return back()->withInput()->with('error','The selected tenant has already been added to this service Charge for the specified start and due date, Check and try again!!');
                    }

                    }
                }
               
            }
        }


        $asset = Asset::where('uuid',$request['asset'])->first();

        if($asset){
                Asset::addServiceCharge($request->all(), $asset);
            return redirect()->route('service.charges')->with('success', 'Service charge added successfully');
        }
        else{
            return back()->with('error', 'Error: asset not found');
        }
    }


 public function  getTenantsServiceCharge($id){
        
    $tsc =  TenantServiceCharge::where('asc_id',$id)->get();

    $tenants=array();
    foreach ($tsc as $key => $ts) {
       $tenants[] =$ts->myTenants($ts->tenant_id);
    }

    dd($tenants);
}

    public function editServiceCharge($id){
        $service_ch = '';
        $service_charge = AssetServiceCharge::find($id);
        foreach (getServiceCharge() as $key => $sc) {
          if($sc->id == $service_charge->service_charge_id){
            $service_ch = $sc->name;
          }
        }

         $tenants = $service_charge->tenant_id;

          $tenants_ids=explode(' ',$tenants); 

           $tenantsServiceCharges =  TenantServiceCharge::where('asc_id',$id)->get();

    $tenantsDetails=array();
    foreach ($tenantsServiceCharges as $key => $ts) {
       $tenantsDetails[] =$ts->myTenants($ts->tenant_id);
    }

       $serviceChType = getServiceChargeType($service_ch);

        return view('new.admin.assets.edit-asset-service-charge',compact('service_charge','serviceChType','tenantsDetails'));
    }


    public function updateServiceCharge(Request $request){
       
        $data = $request->all();
        
       $validator = validator::make($data,
        [
                'asset_id' => 'required',
                'service_charge_id' => 'required',
                'price' => 'required',
                'tenant_id' => 'required'
        ]);

       if($validator->fails()){
            return back()->withErrors($validator)
             ->withInput()->with('error', 'Please fill in a required fields');
       }
       
        DB::beginTransaction();
        try{
            Asset::updateServiceCharge($data);
            DB::commit();
        }
        catch(Exception $e){
            DB::rollback();
            return back()->withInput()->with('error', 'An error occured. Please try again');
        }

        return back()->with('success', 'Service Charge updated successfully');
    }

public function tenantsServiceCharge($id){
            $asset='';
            $tenants=0;
            $serviceChargeName='';
            $amount=0;
           $assetSc = AssetServiceCharge::find($id);

           if($assetSc){
           $asset=$assetSc->asset;
           $serviceChargeName = $assetSc->serviceCharge->name === 'Other' ? $assetSc->description :$assetSc->serviceCharge->name;
           $amount = $assetSc->price;
           $tenants = $assetSc->tenant_id;
          
             }
           $tenantsServiceCharges =  TenantServiceCharge::where('asc_id',$id)->get();

    $tenantsDetails=array();
    foreach ($tenantsServiceCharges as $key => $ts) {
       $tenantsDetails[] =$ts->myTenants($ts->tenant_id);
    }

          return view('new.admin.assets.tenant-service_charges-list',compact('tenantsDetails','tenants','asset','serviceChargeName','amount'));

        }

        public function removeTenantFromCS($tenant_id,$sc_id){

          $scId =  (int)$sc_id;
          $tenantId =  (int)$tenant_id;
         
           
          if(removeTenantFromServiceCharge($tenantId, $scId)){
            removeServiceChargeWithoutTenant($scId);
            return back()->with('success', 'The Selected Tenant has been removed from this service charge');
          }
           return back()->with('error', 'Error: An attempt to remove the selected tenant from this service charge failed, try again');
        }


    public function addUnit(Request $request)
    {
         if(!$this->checkAvailableSlot($request)){
            return back()->withInput()->with('error','You have only ' . getSlots()['availableSlots'] . ' slot left, upgrade to add more assets');
            }

        $validator = Validator::make($request->all(), [
            'unit.*.category' => 'required',
            'unit.*.quantity' => 'required',
            'unit.*.standard_price' => 'required',
            'asset' => 'required'
        ]);
        if ($validator->fails()) {
            return  back()->withErrors($validator)
                        ->withInput()->with('error', 'Please fill in a required fields');
        }
        $asset = Asset::find($request['asset']);
        if($asset){
            Asset::createUnit($request->all(), $asset);
            return back()->with('success', 'Unit added successfully');
        }
        else{
            return back()->with('error', 'Error: asset not found');
        }
    }

    public function serviceCharges()
    {
      
        $charges = AssetServiceCharge::with('asset','serviceCharge')
            ->where('user_id',getOwnerUserID())
            ->where('status',1)
            ->orderBy('created_at','desc')
            ->get();
        $plan = getUserPlan();
        $limit = $plan['details']->properties;
        $limit = $limit == "Unlimited" ? '9999999999999' : $limit;
        $query = Asset::query()
        ->select('assets.uuid','assets.id','assets.address', 'assets.description',
            'assets.price')
        ->where('assets.user_id', getOwnerUserID())->limit($limit);

        $data = [
            'assetsCategories' => $query->orderBy('assets.id', 'desc')->get(),
            'charges' => $charges
        ];
        return view('new.admin.assets.service_charges', $data);
    }

  public function  AssetServiceCharges($assetId){
     $charges = AssetServiceCharge::with('asset','serviceCharge')
            ->where('user_id',getOwnerUserID())
            ->where('status',1)
            ->where('asset_id',$assetId)
            ->orderBy('created_at','desc')->get();
    $asset = Asset::find($assetId);
    $asset = $asset->description;
   return view('new.admin.assets.partials.viewServiceCharge', compact('charges','asset'));

    }

    public function checkAvailableSlot($request){

     $units = $request->unit ? $request->unit : $request->all;
     $totalUnit = 0;
       foreach ($units as $key => $unit) {
            $totalUnit += $unit['quantity'];
       }

       if( $totalUnit > (int)getSlots()['availableSlots']){
         return false;
       }else{
        return true;
       }
    }

public function getAssetLocation($asset_id){
        $address = Asset::where('id',$asset_id)->get();

         return response()->json($address);
}
public function search_Service_Charge(Request $request){

     $data = $request->all();

    $validator = validator::make($data,[
        'asset' => 'required',
        'location' => 'required',
        'type' => 'required',
        'service_name' => 'required',
        'minAmt' => 'required',
        'maxAmt' => 'required',
    ]);

    if($validator->fails()){
         return  back()->withErrors($validator)
                        ->withInput()->with('error', 'Please fill in a required fields');
    }

    if($data['minAmt'] > $data['maxAmt']){
       return  back()->withInput()->with('error', 'Invalid amount range: Min. Amount cannot be more than max. Amount');
     }


    $assetId = $request->asset;
     if($assetId){
            $assetsServiceCharges = AssetServiceCharge::where('asset_service_charges.asset_id', $assetId)
            ->where('a.address', $request->location)
            ->whereBetween('asset_service_charges.price', [$request->minAmt, $request->maxAmt])
            ->where('s.type', $request->type)
            ->where('s.name', $request->service_name)
            ->where('asset_service_charges.user_id',getOwnerUserID())
            ->join('service_charges as s', 's.id', '=', 'asset_service_charges.service_charge_id')
            ->join('assets as a', 'a.id', '=', 'asset_service_charges.asset_id')
            ->selectRaw('a.*, s.*,asset_service_charges.*')
            ->get();
           return view('new.admin.assets.service_charges',compact('assetsServiceCharges'));
           
        }
        
    
}
public function array_equal($a, $b) {
    return (
         is_array($a) 
         && is_array($b) 
         && count($a) == count($b) 
         && array_diff($a, $b) === array_diff($b, $a)
    );
}
}
