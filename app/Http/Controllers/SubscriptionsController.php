<?php

namespace App\Http\Controllers;

use App\Subscription;
use App\SubscriptionPlan;
use App\Transaction;
use App\User;
use App\Http\Requests\SubRequest;
use Illuminate\Support\Facades\Hash;
use App\Asset;
use App\Staff;
use App\AssignedAsset;
use DB;
use Illuminate\Http\Request;

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
        return view('new.admin.subs.buy', compact('plan'));
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

    public function process_buy_plan(Request $request)
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
            'end' => date('Y-m-d H:i:s', strtotime('+'.$request->period.' months')),
            'reference' => $transaction->reference,
            'plan_id' => $request->plan_id,
            'status' => 'Pending'
        ]);
        $paymentData = [
            'email' => $request->email,
            'amount' => fixKobo($transaction->amount), // amount is in kobo so add 00
            'metadata' => [
                'subscription' => $sub->uuid,
                'transaction' => $transaction->uuid,
                'payment_reference' => $transaction->reference
            ]
        ];
        $pay = $this->makePayment($paymentData);
        if($pay['status']){
            return redirect($pay['payment_url']);
        }
        else{
            return back()->with('error', 'An error occured. Could not reach payment provider');
        }
    }

    public function makePayment($paymentData)
    {
        $curl = curl_init();

        $sk = env('PAYSTACK_SECRET_KEY');
        $url = env('PAYSTACK_PAYMENT_URL');

        curl_setopt_array($curl, array(
            CURLOPT_URL => "{$url}/transaction/initialize",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => json_encode([
                'amount'=> $paymentData['amount'],
                'email'=> $paymentData['email'],
                'metadata' => $paymentData['metadata']
            ]),
            CURLOPT_HTTPHEADER => [
                "authorization: Bearer {$sk}", //replace this with your own test key
                "content-type: application/json",
                "cache-control: no-cache"
            ],
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        if($err){
            // there was an error contacting the Paystack API
            die('Curl returned error: ' . $err);
        }

        $tranx = json_decode($response, true);

        if(!$tranx['status']){
            // there was an error from the API
            return [
                'status' => false
            ];
        }

        return [
            'status' => true,
            'payment_url' => $tranx['data']['authorization_url']
        ];
    }

    public function handleGatewayCallback()
    {
        $curl = curl_init();
        $reference = isset($_GET['reference']) ? $_GET['reference'] : '';
        if(!$reference){
            die('No reference supplied');
        }

        $sk = env('PAYSTACK_SECRET_KEY');
        $url = env('PAYSTACK_PAYMENT_URL');

        curl_setopt_array($curl, array(
            CURLOPT_URL => "{$url}/transaction/verify/" . rawurlencode($reference),
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER => [
                "accept: application/json",
                "authorization: Bearer {$sk}",
                "cache-control: no-cache"
            ],
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        if($err){
            // there was an error contacting the Paystack API
            die('Curl returned error: ' . $err);
        }

        $tranx = json_decode($response);

        if(!$tranx->status){
            // there was an error from the API
            die('API returned error: ' . $tranx->message);
        }

        if('success' == $tranx->data->status){
            // transaction was successful...
            // please check other things like whether you already gave value for this ref
            // if the email matches the customer who owns the product etc
            // Give value
            $reference = $tranx->data->metadata->payment_reference;
            $subscription = $tranx->data->metadata->subscription;
            $provider_reference = $tranx->data->reference;
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

            return redirect()->to('home')->with('success', 'Congratulations! Your upgrade was successful!');
        }
    }




}
