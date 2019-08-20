<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use DB;
use App\Maintenance;
use App\Asset;

class MaintenanceController extends Controller
{
    public function index()
    {
        $maintenances = Maintenance::where('user_id', getOwnerUserID())->with('categoryy')->get();
        return view('new.admin.maintenance.index', compact('maintenances'));
    }

    public function create()
    {
        $plan = getUserPlan();
        $limit = $plan['details']->properties;
        $limit = $limit == "Unlimited" ? '9999999999999' : $limit;
        $properties = Asset::select(
            'assets.uuid',
            'assets.id',
            'assets.address',
            'assets.description',
            'assets.price'
        )
        ->where('assets.user_id', getOwnerUserID())->limit($limit)->get();

        return view('new.admin.maintenance.create', compact('properties'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'customer' => 'required',
            // 'category' => 'required',
            'asset_description' => 'required',
            'building_section' => 'required',
            'reported_date' => 'required|date_format:"d/m/Y"',
            'status' => 'required',
            'fault_description' => 'required',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)
                        ->withInput()->with('error', 'Please fill in a required fields');
        }

        Maintenance::createNew($request->all());

        return redirect()->route('maintenance.index')->with('success', 'Maintenance added successfully');
    }

    public function delete($uuid)
    {
        $maintenance = Maintenance::where('uuid', $uuid)->first();
        if($maintenance){
            $maintenance->delete();
            return back()->with('success', 'Maintenance deleted successfully');
        }
        else{
            return back()->with('error', 'Whoops! Could not find maintenance');
        }
    }

    /**
     * Edit maintenance
     */
    public function edit($uuid)
    {
        $maintenance = Maintenance::where('uuid', $uuid)->first();
        if($maintenance){
            return view('new.admin.maintenance.edit', compact('maintenance'));
        }
        else{
            return back()->with('error', 'Whoops! Could not find maintenance');
        }
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'customer' => 'required',
            // 'category' => 'required',
            'asset_description' => 'required',
            'building_section' => 'required',
            'reported_date' => 'required|date_format:"d/m/Y"',
            'status' => 'required',
            'fault_description' => 'required',
            'uuid' => 'required',
        ]);
        if ($validator->fails()) {
            return back()->withErrors($validator)
                        ->withInput()->with('error', 'Please fill in a required fields');
        }

        Maintenance::updateMintenance($request->all());
        return redirect()->route('maintenance.index')->with('success', 'Maintenance updated successfully');
    }
}
