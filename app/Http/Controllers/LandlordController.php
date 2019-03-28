<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Landlord;
use Validator;
use DB;

class LandlordController extends Controller
{
    public function index()
    {
        $landlords = Landlord::orderBy('firstname')->get();
        return view('admin.landlord.index', compact('landlords'));
    }

    public function create()
    {
        return view('admin.landlord.create');
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

        Landlord::createNew($request->all());

        return redirect()->route('landlord.index')->with('success', 'Landlord added successfully');
    }

    public function delete($uuid)
    {
        $landlord = Landlord::where('uuid', $uuid)->first();

        if(count($landlord->asset) > 0){
            return back()->with('error', 'Whoops! Cannot delete a landlord with already assigned asset(s)');
        }

        if($landlord){
            $landlord->delete();
            return back()->with('success', 'Landlord deleted successfully');
        }
        else{
            return back()->with('error', 'Whoops! Could not find landlord');
        }
    }

    public function edit($uuid)
    {
        $landlord = Landlord::where('uuid', $uuid)->first();
        if($landlord){
            return view('admin.landlord.edit', compact('landlord'));
        }
        else{
            return back()->with('error', 'Whoops! Could not find landlord');
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

        Landlord::updateLandlord($request->all());
        return redirect()->route('landlord.index')->with('success', 'Landlord added successfully');
    }
}
