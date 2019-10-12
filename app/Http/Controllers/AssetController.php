<?php

namespace App\Http\Controllers;

use App\Asset;
use App\AssetPhoto;
use App\AssetServiceCharge;
use App\AssignedAsset;
use App\Tenant;
use App\Unit;
use DB;
use Illuminate\Http\Request;
use Validator;

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
            'landlord' => 'required',
            'country' => 'required',
            'state' => 'required',
            'city' => 'required',
            'address' => 'required',
            'detailed_information' => 'required',
            'features.*' => 'required',
            'photos.*' => 'image',
            'commission' => 'required|numeric',
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
        // $this->checkAvailableSlot($request);

        $validator = Validator::make($request->all(), [
            'description' => 'required',
            'commission' => 'required|numeric',
            // 'quantity' => 'required',
            // 'standard_price' => 'required',
            'landlord' => 'required',
            'country' => 'required',
            'state' => 'required',
            'city' => 'required',
            'address' => 'required',
            'detailed_information' => 'required',
            // 'bedrooms' => 'required',
            // 'bathrooms' => 'required',
            'features.*' => 'required',
            'uuid' => 'required',
            'unit.*.category' => 'required',
            'unit.*.quantity' => 'required',
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

        // if($request->has('search') && $request['search']){
        //     $search = $request['search'];
        //     $query->where('assets.description', 'like', "%{$search}%")
        //     ->orWhere('assets.address', 'like', "%{$search}%")
        //     ->orWhere('categories.name', 'like', "%{$search}%");
        // }
        $data = [
            'assets' => $query,
            'term' => ''
        ];
        return view('new.admin.assets.my', $data);
    }

    public function createServiceCharge(Request $request){
        return view('new.admin.assets.create_asset_service_charge');
    }

    public function addServiceCharge(Request $request)
    {
        // dd($request->all());
        $validator = Validator::make($request->all(), [
            'service.*.type' => 'required',
            'service.*.service_charge' => 'required',
            'service.*.price' => 'required',
            'asset' => 'required',
            'tenant_id' => 'required'
        ]);
        if ($validator->fails()) {
            return back()->withErrors($validator)
                        ->withInput()->with('error', 'Please fill in a required fields');
        }
        $asset = Asset::find($request['asset']);

        if($asset){
            foreach($request['service'] as $unit){
                /*$exists = AssetServiceCharge::where([
                    ['asset_id', $asset->id],
                    ['service_charge_id', $unit['service_charge']],
                ])->get();

                if(count($exists) > 0){
                    return back()->with('error', 'Service charge already added');
                }*/
                Asset::addServiceCharge($request->all(), $asset);
            }
            return redirect()->route('service.charges')->with('success', 'Service charge added successfully');
        }
        else{
            return back()->with('error', 'Error: asset not found');
        }
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

         $tenantsDetails=array();
          foreach ($tenants_ids as $key => $id) {
         $tens = Tenant::where('id',(int)$id)->first();
         if($tens){
            $tenantsDetails[] = $tens;
            }
          }

       $serviceChType = getServiceChargeType($service_ch);

        return view('new.admin.assets.edit-asset-service-charge',compact('service_charge','serviceChType','tenantsDetails'));
    }


    public function updateServiceCharge(Request $request){
       
        $data = $request->all();
      //  dd($data);
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
       
           $assetSc = AssetServiceCharge::find($id);
           $asset=$assetSc->asset;
           $serviceChargeName = $assetSc->serviceCharge->name;
           $amount = $assetSc->price;
          $tenants = $assetSc->tenant_id;
          $tenants_ids=explode(' ',$tenants); 

         $tenantsDetails=array();
          foreach ($tenants_ids as $key => $id) {
         $tens = Tenant::where('id',(int)$id)->first();
         if($tens){
            $tenantsDetails[] = $tens;
            }
          }

          return view('new.admin.assets.tenant-service_charges-list',compact('tenantsDetails','tenants','asset','serviceChargeName','amount'));
        }

        public function removeTenantFromCS($sc_id,$tenant_id){

          $tenantId =  (int)$tenant_id;
          $scId =  (int)$sc_id;

          if(removeTenantFromServiceCharge($tenantId, $scId)){
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
       /* $charges = AssetServiceCharge::join('assets', 'asset_service_charges.asset_id', '=', 'assets.id')
         ->where('assets.user_id', getOwnerUserID())
         ->where('status', 1)
         ->with('asset')
         ->select('asset_service_charges.*')
         ->get();*/
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

    $validator = validator::make($request->all(),[
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
}
