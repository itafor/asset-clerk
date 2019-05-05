<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use App\TenantRent;

class RentalController extends Controller
{
    public function index()
    {
        $rentals = TenantRent::where('user_id', getOwnerUserID())
        ->orderBy('id', 'desc')->get();
        return view('admin.rental.index', compact('rentals'));
    }

    public function create()
    {
        return view('admin.rental.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'tenant' => 'required',
            'property' => 'required',
            'unit' => 'required',
            'price' => 'required|numeric',
            'duration' => 'required|in:1,2,3,4,5',
            'date' => 'required|date_format:"m/d/Y"'
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)
                        ->withInput()->with('error', 'Please fill in a required fields');
        }

        TenantRent::createNew($request->all());

        return redirect()->route('rental.index')->with('success', 'Rental logged successfully');
    }

    public function delete($uuid)
    {
        $tenant = TenantRent::where('uuid', $uuid)->first();
        if($tenant){
            $tenant->delete();
            return back()->with('success', 'Rental deleted successfully');
        }
        else{
            return back()->with('error', 'Whoops! Could not find rental');
        }
    }

    public function approvals()
    {
        return view('admin.rental.approvals');
    }
}
