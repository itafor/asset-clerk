<?php

namespace App\Http\Controllers;

use App\SubPaymentMetalDatas;
use App\Subscription;
use App\SubscriptionPlan;
use App\Transaction;
use App\Unit;
use App\User;
use Auth;
use Illuminate\Http\Request;
use Unicodeveloper\Paystack\Facades\Paystack;

class SubscriptionsController extends Controller
{

    /**
     * Display a listing of the subs
     *
     * @param  \App\User  $model
     * @return \Illuminate\View\View
     */
    public function subscribe()
    {
        return view('new.admin.subs.subscriptions');
    }

    /**
     * Show the form for creating a new user
     *
     * @return \Illuminate\View\View
     */
    public function buy_plan($plan_id = null)
    {
        $plan = SubscriptionPlan::where('uuid', $plan_id)->first();
        $plan_amount = str_replace(".", "", $plan->amount);
        return view('new.admin.subs.buy', compact('plan','plan_amount'));
    }

    public function history(){
        $user = auth()->id();
        $subs = Subscription::where('user_id', $user)->orderBy('created_at', 'desc')->get();
        return view('new.admin.subscriptions.index', compact('subs'));
    }

    public function transactions(){
        $user = auth()->id();
        $subs = Transaction::where('user_id', $user)->orderBy('created_at', 'desc')->get();
        return view('new.admin.subscriptions.transactions', compact('subs'));
    }


       /**
     * Redirect the User to Paystack Payment Page
     * @return Url
     */
    public function redirectToGateway(Request $request)
    {
            $transaction = Transaction::create([
            'user_id' => auth()->id(),
            'plan_id' => $request->plan_id,
            'status' => 'Pending',
            'channel' => 'Paystack',
            'reference' => generateUUID(),
            'amount' => $request->amount * $request->period
        ]);
        $sub = Subscription::create([
            'user_id' => auth()->id(),
            'transaction_id' => $transaction->uuid,
            'start' => date('Y-m-d H:i:s'),
            'end' => date('Y-m-d H:i:s', strtotime('+'.$request->period.' years')),
            'reference' => $transaction->reference,
            'plan_id' => $request->plan_id,
            'status' => 'Pending'
        ]);
        if($sub){
         SubPaymentMetalDatas::create([
            'user_id' => auth()->id(),
            'email' => $request->email,
            'amount' => fixKobo($transaction->amount), // amount is in kobo so add 00
            'subscription_uuid' => $sub->uuid,
           'transaction_uuid' => $transaction->uuid,
            'payment_reference' => $transaction->reference,
            'plan_id' => $sub->plan_id
        ]);

        }

            
     return Paystack::getAuthorizationUrl()->redirectNow();
    }
    /**
     * Obtain Paystack payment information
     * @return void
     */

    public function handleGatewayCallback()
    {
        $paymentDetails = Paystack::getPaymentData();
        // Now you have the payment details,
        // you can store the authorization_code in your db to allow for recurrent subscriptions
        // you can then redirect or do whatever you want

        if($paymentDetails['status'] == true){
            //dd('transaction was successful...');
            // transaction was successful...
            // please check other things like whether you already gave value for this ref
            // if the email matches the customer who owns the product etc
            // Give value

            $getMetadata = SubPaymentMetalDatas::where('user_id',getOwnerUserID())->latest()->first();
            if($getMetadata){
            $reference = $getMetadata->payment_reference;
            $subscription = $getMetadata->subscription_uuid;
            $provider_reference = $paymentDetails['data']['reference'];
            $status = 'Success';

            $txn = Transaction::where('reference',$reference)->first();
            $txn = Transaction::find($txn->id);
            $txn->update([
                'status' => 'Successful',
                'provider_reference' => $provider_reference
            ]);
            //Find if user has any active subscription
            $active = Subscription::where('user_id', auth()->id())->where('status','Active')->get();
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
            $this->updateUnitSetPlanIdNull($getMetadata->plan_id);
            $this->removeMetaData($getMetadata->id,$getMetadata->user_id);
            return redirect()->to('home')->with('success', 'Congratulations! Your upgrade was successful!');
        }
      }
    }

public function updateUnitSetPlanIdNull($plan_id){

    $getPlanIds = Unit::where('plan_id', $plan_id)
          ->where('user_id',getOwnerUserID())
          ->get();
    
    if($getPlanIds){
      foreach ($getPlanIds as $key => $value) {
          Unit::where('plan_id',$value->plan_id)
          ->where('user_id',getOwnerUserID())
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
