<?php

namespace App\Http\Controllers;

use App\Asset;
use App\Mail\PaymentCreated;
use App\RentPayment;
use App\TenantRent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Validator;

class RentPaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($uuid)
    {
       $tenantRent = TenantRent::where('uuid',$uuid)
       ->where('user_id',getOwnerUserID())->first();

        $plan = getUserPlan();
        $limit = $plan['details']->properties;
        $limit = $limit == "Unlimited" ? '9999999999999' : $limit;
        $properties = Asset::select('assets.uuid','assets.id','assets.address', 'assets.description',
            'assets.price')
        ->where('assets.user_id', getOwnerUserID())->limit($limit)->get();

        return view('new.admin.rentPayment.create', compact('tenantRent','properties'));
       //dd($tenantRent);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

       // dd($request->all());

        $validator = validator::make($request->all(),[
        'tenant_uuid' => 'required',
        'asset_uuid' => 'required',
        'unit_uuid' => 'required',
        'tenantRent_uuid' => 'required',
        'proposed_amount' => 'required|numeric',
        'actual_amount' => 'required|numeric',
        'amount_paid' => 'required|numeric',
        'balance' => 'required|numeric',
        'payment_mode_id' => 'required|numeric',
        'payment_date' =>'required',
        'payment_description' => 'required',
        'balance' => 'required|numeric',
        'startDate' => 'required',
        'due_date' => 'required',
        ]);
        if($validator->fails()){
            return back()->withErrors($validator)
                        ->withInput()->with('error', 'Please fill in required fields');
        }

        DB::beginTransaction();
        try {
          $payment = RentPayment::createNew($request->all());
              $toEmail = $payment->unit->getTenant()->email;
            Mail::to($toEmail)->send(new PaymentCreated($payment));
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            return back()->withInput()->with('error', 'An error occured. Please try again');
        }
         return back()->with('success', 'Rent payment recorded successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\RentPayment  $rentPayment
     * @return \Illuminate\Http\Response
     */
    public function show(RentPayment $rentPayment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\RentPayment  $rentPayment
     * @return \Illuminate\Http\Response
     */
    public function edit(RentPayment $rentPayment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\RentPayment  $rentPayment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, RentPayment $rentPayment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\RentPayment  $rentPayment
     * @return \Illuminate\Http\Response
     */
    public function destroy(RentPayment $rentPayment)
    {
        //
    }
}
