<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Asset;
use App\AssetPhoto;
use App\Unit;
use App\AssignedAsset;
use App\AssetServiceCharge;
use Validator;
use DB;

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

    public function addServiceCharge(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'service.*.type' => 'required',
            'service.*.service_charge' => 'required',
            'service.*.price' => 'required',
            'asset' => 'required'
        ]);
        if ($validator->fails()) {
            return back()->withErrors($validator)
                        ->withInput()->with('error', 'Please fill in a required fields');
        }
        $asset = Asset::find($request['asset']);

        if($asset){
            foreach($request['service'] as $unit){
                $exists = AssetServiceCharge::where([
                    ['asset_id', $asset->id],
                    ['service_charge_id', $unit['service_charge']],
                ])->get();

                if(count($exists) > 0){
                    return back()->with('error', 'Service charge already added');
                }
                Asset::addServiceCharge($request->all(), $asset);
            }
            return back()->with('success', 'Service charge added successfully');
        }
        else{
            return back()->with('error', 'Error: asset not found');
        }
    }

    public function addUnit(Request $request)
    {
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
         $charges = AssetServiceCharge::join('assets', 'asset_service_charges.asset_id', '=', 'assets.id')
         ->where('assets.user_id', getOwnerUserID())
         ->where('status', 1)
         ->with('asset')
         ->select('asset_service_charges.*')
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
}
