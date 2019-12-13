<?php

namespace App\Http\Controllers;

use App\SubPaymentMetalDatas;
use App\Subscription;
use App\SubscriptionPlan;
use App\Transaction;
use App\Unit;
use App\User;
use Illuminate\Http\Request;

class ManualSubscriptionController extends Controller
{
     /**
     * Show the form for creating a new user
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('new.admin.manual_subs.create');
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
  
  public function process_user_plan(Request $request) {
    	//dd($request->all());
 $transaction = Transaction::create([
            'user_id' => $request->user_id,
            'plan_id' => $request->plan_id,
            'status' => 'Pending',
            'channel' => $request->name =='Free' ? 'Free Signup':'Manual',
            'reference' => generateUUID(),
            'amount' => $request->amount * $request->period
        ]);
        $sub = Subscription::create([
            'user_id' => $request->user_id,
            'transaction_id' => $transaction->uuid,
            'start' => date('Y-m-d H:i:s'),
            'end' => date('Y-m-d H:i:s', strtotime('+'.$request->period.' years')),
            'reference' => $transaction->reference,
            'plan_id' => $request->plan_id,
            'status' => 'Pending'
        ]);
        if($sub){
         SubPaymentMetalDatas::create([
            'user_id' => $request->user_id,
            'email' => $request->email,
            'amount' => fixKobo($transaction->amount), // amount is in kobo so add 00
            'subscription_uuid' => $sub->uuid,
           'transaction_uuid' => $transaction->uuid,
            'payment_reference' => $transaction->reference,
            'plan_id' => $sub->plan_id
        ]);
         $this->finalize_plan_processing($request->all());
         return redirect()->to('home')->with('success', 'Congratulations! Selected user plan upgrade was successful!');
        }

    }


    public function finalize_plan_processing($data)
    {
       
        if($data['user_id']){
            
            $getMetadata = SubPaymentMetalDatas::where('user_id',$data['user_id'])->latest()->first();
            if($getMetadata){
            $reference = $getMetadata->payment_reference;
            $subscription = $getMetadata->subscription_uuid;
            $provider_reference = generateUUID();// $paymentDetails['data']['reference'];
            $status = 'Success';

            $txn = Transaction::where('reference',$reference)->first();
            $txn = Transaction::find($txn->id);
            $txn->update([
                'status' => 'Successful',
                'provider_reference' => $provider_reference
            ]);
            //Find if user has any active subscription
            $active = Subscription::where('user_id', $data['user_id'])->where('status','Active')->get();
            if(!is_null($active)){
                foreach ($active as $act){
                    $sub_ = Subscription::find($act->id);
                    $sub_->update([
                        'status' => 'Revoked'
                    ]);
                }
            }
            $sub = Subscription::where('reference',$reference)->first();
            $sub = Subscription::find($sub->id);
            $sub->update([
                'status' => 'Active'
            ]);
            $this->updateUnitSetPlanIdNull($getMetadata->plan_id,$data['user_id']);
            $this->removeMetaData($getMetadata->id,$getMetadata->user_id);
        }
      }
    }

    public function updateUnitSetPlanIdNull($plan_id,$userId){

    $getPlanIds = Unit::where('plan_id', $plan_id)
          ->where('user_id',$userId)
          ->get();
    
    if($getPlanIds){
      foreach ($getPlanIds as $key => $value) {
          Unit::where('plan_id',$value->plan_id)
          ->where('user_id',$userId)
          ->update([
            'plan_id' => null
          ]);
      }
   }
 }
public function removeMetaData($id,$user_id){
          $smd = SubPaymentMetalDatas::where('id',$id)
          ->where('user_id',$user_id)->latest()->first();
         if($smd){
        $smd->delete();
         }
    }
}
