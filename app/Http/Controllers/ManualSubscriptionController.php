<?php

namespace App\Http\Controllers;

use App\SubscriptionPlan;
use App\User;
use Illuminate\Http\Request;

class ManualSubscriptionController extends Controller
{
     /**
     * Show the form for creating a new user
     *
     * @return \Illuminate\View\View
     */
    public function create($plan_id = '5ca8edad-1878-47f2-a868-8af143b06212')
    {
        $plan = SubscriptionPlan::where('uuid', $plan_id)->first();
        $plan_amount = str_replace(".", "", $plan->amount);
        return view('new.admin.manual_subs.create', compact('plan','plan_amount'));
    }

    public function fetchUserEmail($userId){
    	$user_email=User::where('id',$userId)->first();
    	if($user_email){
    		return response()->json($user_email);
        }
        else{
            return [];
        }
    }
   public function fetchPlanPrice($plan_name){
    	$planName=SubscriptionPlan::where('name',$plan_name)->first();
    	if($planName){
    		return response()->json($planName);
        }
        else{
            return [];
        }
    }
}
