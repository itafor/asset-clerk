<?php

namespace App\Http\Controllers;

use App\Subscription;
use App\SubscriptionPlan;
use App\Transaction;
use Illuminate\Http\Request;
use App\Landlord;
use Validator;
use DB;

class AdminController extends Controller
{
    public function subscription_plans()
    {
        $plans = SubscriptionPlan::all();
        return view('new.admin.plans.index', compact('plans'));
    }

    public function transactions()
    {
        $plans = Transaction::all();
        return view('new.admin.transactions.index', compact('plans'));
    }

    public function subscribers()
    {
        $plans = Subscription::all();
        return view('new.admin.subscriptions.index', compact('plans'));
    }

    public function create_subscription_plan()
    {
        return view('new.admin.plans.create');
    }

    public function save_subscription_plan(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'properties' => 'required',
            'service_charge' => 'required',
            'sub_accounts' => 'required',
            'amount' => 'required',
            'description' => 'required'
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)
                        ->withInput()->with('error', 'Please fill in a required fields');
        }

        SubscriptionPlan::createNew($request->all());

        return redirect()->route('plan.index')->with('success', 'Plan created successfully');
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
            return view('new.admin.landlord.edit', compact('landlord'));
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
        return redirect()->route('landlord.index')->with('success', 'Landlord updated successfully');
    }
}
