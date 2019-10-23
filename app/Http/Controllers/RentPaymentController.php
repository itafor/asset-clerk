<?php

namespace App\Http\Controllers;

use App\Asset;
use App\RentPayment;
use App\TenantRent;
use Illuminate\Http\Request;

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
        //
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
