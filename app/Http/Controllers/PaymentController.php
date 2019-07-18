<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Payment;
use App\Asset;
use Validator;
use App\Mail\PaymentCreated;
use Mail;
use DB;

class PaymentController extends Controller
{
    public function index()
    {
        $payments = Payment::where('user_id', getOwnerUserID())->with('unit', 'paymentMode', 'paymentType')->get();
        return view('new.admin.payment.index', compact('payments'));
    }

    public function create()
    {
        $plan = getUserPlan();
        $limit = $plan['details']->properties;
        $properties = Asset::select('assets.uuid','assets.id','assets.address', 'assets.description',
            'assets.price')
        ->where('assets.user_id', getOwnerUserID())->limit($limit)->get();
        return view('new.admin.payment.create', compact('properties'));
    }

    public function store(Request $request)
    {
        $serviceChargeID = env('SERVICE_CHARGE_ID');
        $validator = Validator::make($request->all(), [
            'property' => 'required|exists:assets,uuid',
            'unit' => 'required|exists:units,uuid',
            'payment_type' => 'required|exists:payment_types,id',
            'service_charge' => 'nullable|required_if:payment_type,'.$serviceChargeID.'|exists:service_charges,id',
            'payment_date' => 'required|date_format:"d/m/Y"',
            'amount' => 'required|numeric',
            'payment_mode' => 'required|exists:payment_modes,id',
            'description' => 'required',
        ]);
        if ($validator->fails()) {
            return back()->withErrors($validator)
                        ->withInput()->with('error', 'Please fill in all required fields.');
        }
        DB::beginTransaction();
        try{
            $payment = Payment::createNew($request->all());
            $toEmail = $payment->unit->getTenant()->email;
            Mail::to($toEmail)->send(new PaymentCreated($payment));
            DB::commit();
        } catch(Exception $e) {
            DB::rollback();
            return back()->with('error', 'Whoops! An error occured. Please try again');
        }
        return redirect()->route('payment.index')->with('success', 'Payment created successfully');
    }

    public function edit($uuid)
    {
        $payment = Payment::where('uuid', $uuid)->first();
        if($payment){
            $plan = getUserPlan();
            $limit = $plan['details']->properties;
            $properties = Asset::select('assets.uuid','assets.id','assets.address', 'assets.description',
                'assets.price')
            ->where('assets.user_id', getOwnerUserID())->limit($limit)->get();
            return view('new.admin.payment.edit', compact('payment', 'properties'));
        }
        else{
            return back()->with('error', 'Whoops! Could not find payment');
        }
    }

    public function update(Request $request)
    {
        $serviceChargeID = env('SERVICE_CHARGE_ID');
        $validator = Validator::make($request->all(), [
            'property' => 'required|exists:assets,uuid',
            'unit' => 'required|exists:units,uuid',
            'payment_type' => 'required|exists:payment_types,id',
            'service_charge' => 'nullable|required_if:payment_type,'.$serviceChargeID.'|exists:service_charges,id',
            'payment_date' => 'required|date_format:"d/m/Y"',
            'amount' => 'required|numeric',
            'payment_mode' => 'required|exists:payment_modes,id',
            'description' => 'required',
            'payment' => 'required|exists:payments,uuid'
        ]);
        if ($validator->fails()) {
            return back()->withErrors($validator)
                        ->withInput()->with('error', 'Please fill in all required fields.');
        }
        try{
            Payment::updatePayment($request->all(), $serviceChargeID);
        } catch(\Exception $e) {
            return back()->with('error', 'Whoops! An error occured. Please try again');
        }
        return redirect()->route('payment.index')->with('success', 'Payment updated successfully');
    }

    public function delete($uuid)
    {
        $py = Payment::where('uuid', $uuid)->first();
        if($py){
            $py->delete();
            return back()->with('success', 'Payment deleted successfully');
        }
        else{
            return back()->with('error', 'Whoops! Could not find payment');
        }
    }
}
