<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use DB;
use App\Tenant;

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
            'date_of_birth' => 'required|date_format:"m/d/Y"',
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
            return back()->withInput()->with('error', 'Oops! An error occured. Please try again');
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
            'date_of_birth' => 'required|date_format:"m/d/Y"',
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
