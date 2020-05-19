<?php

namespace App\Http\Controllers;

use App\SubPaymentMetalDatas;
use App\Subscription;
use App\Transaction;
use App\Unit;
use Illuminate\Http\Request;

class BankTransferSubscriptionsController extends Controller
{
        /**
     * Redirect the User to Direct bank transfer Payment Page
     * @return Url
     */
    public function buyPlanByDirectBankTransfer(Request $request)
    {
            $transaction = Transaction::create([
            'user_id' => auth()->id(),
            'plan_id' => $request->plan_id,
            'status' => 'Pending',
            'channel' => 'Bank Transfer',
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
            'status' => 'Pending',
            'channel' => 'Bank Transfer'
        ]);
        if($sub){
         SubPaymentMetalDatas::create([
            'user_id' => auth()->id(),
            'email' => $request->email,
            'amount' => fixKobo($transaction->amount), // amount is in kobo so add 00
            'subscription_uuid' => $sub->uuid,
            'transaction_uuid' => $transaction->uuid,
            'payment_reference' => $transaction->reference,
            'plan_id' => $sub->plan_id,
            'bank_transfer_reference' => generateUUID(),
        ]);

        }
	
	return redirect()->to('home')->with('success', 'Congratulations, request logged successfully, Pending approval!');
            
    }

   public function activatePendingSubscribers($user_id,$sub_uuid)
    {
       $subs=Subscription::join('sub_payment_metal_datas as md','md.subscription_uuid','=','subscriptions.uuid')
       ->where('subscriptions.uuid',$sub_uuid)
      ->where('subscriptions.user_id',$user_id)
      ->select('subscriptions.uuid as subuuid','md.bank_transfer_reference as bnkref')
      ->first();
     
        
        if($subs){
            $getMetadata = SubPaymentMetalDatas::where('user_id',$user_id)
            ->where('subscription_uuid',$subs->subuuid)
            ->where('bank_transfer_reference',$subs->bnkref)->first();
            
             //dd($getMetadata);
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
            $active = Subscription::where('user_id',$user_id)->where('status','Active')->get();
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
            $this->updateUnitSetPlanIdNull($getMetadata->plan_id,$user_id);
           // $this->removeMetaData($getMetadata->id,$getMetadata->user_id,$sub_uuid);

            return redirect()->to('home')->with('success', 'Plan activated successfully!');
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
public function removeMetaData($id,$user_id,$subUuid){
          $smd = SubPaymentMetalDatas::where('id',$id)
          ->where('user_id',$user_id)
          ->where('subscription_uuid',$subUuid)->latest()->first();
         if($smd){
        $smd->delete();
         }
    }
}
