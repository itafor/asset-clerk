<?php

namespace App\Http\Controllers;

use App\ServiceChargePaymentHistory;
use App\TenantServiceCharge;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Validator;

class AssetServiceChargeController extends Controller
{
    public function getDebtors(){
    	  $debtors = TenantServiceCharge::join('asset_service_charges', 'asset_service_charges.id', '=', 'tenant_service_charges.asc_id')
    	  ->join('tenants','tenants.id','=','tenant_service_charges.tenant_id')
    	  ->join('service_charges','service_charges.id','=','tenant_service_charges.service_chargeId')
         ->where('tenant_service_charges.user_id', getOwnerUserID())
         ->select('tenant_service_charges.*','asset_service_charges.*','tenants.*','service_charges.*')
         ->get();
          return view('new.admin.assetServiceCharge.debtors', compact('debtors'));
         
    }

   

    public function getTenantServiceCharge($id){
         $tenantServiceCharges = TenantServiceCharge::join('asset_service_charges', 'asset_service_charges.id', '=', 'tenant_service_charges.asc_id')
          ->join('tenants','tenants.id','=','tenant_service_charges.tenant_id')
          ->join('service_charges','service_charges.id','=','tenant_service_charges.service_chargeId')
         ->where('tenant_service_charges.user_id', getOwnerUserID())
         ->where('tenants.id', $id)
         ->select('service_charges.*','asset_service_charges.dueDate as expireingDate')
         ->get();

         return $tenantServiceCharges;
    }


    public function getServiceChargeAmount($id,$tenantId){
        $ServiceChargesAmount = TenantServiceCharge::join('asset_service_charges', 'asset_service_charges.id', '=', 'tenant_service_charges.asc_id')
          ->join('tenants','tenants.id','=','tenant_service_charges.tenant_id')
          ->join('service_charges','service_charges.id','=','tenant_service_charges.service_chargeId')
          ->join('assets','assets.id','=','asset_service_charges.asset_id')
         ->where('tenant_service_charges.user_id', getOwnerUserID())
        ->where('tenant_service_charges.service_chargeId', $id)
        ->where('tenant_service_charges.tenant_id', $tenantId)
         ->select('service_charges.*','asset_service_charges.*','tenant_service_charges.*','assets.description as property','asset_service_charges.dueDate as expireingDate')
         ->get();
         return $ServiceChargesAmount;
    }

     public function payServiveCharge(){
        return view('new.admin.assetServiceCharge.service-charge-payment');
    }

     public function storeServiveChargePaymentHistory(Request $request){

        $validator = validator::make($request->all(),[
        'tenant' => 'required',
        'service_charge' => 'required',
        'actualAmount' => 'required',
        'balance' => 'required',
        'property' => 'required',
        'amountPaid' => 'required',
        'payment_mode' => 'required',
        'payment_date' => 'required',
        'durationPaidFor' => 'required',
        'payment_mode' => 'required',
        ]);
        if($validator->fails()){
            return back()->withErrors($validator)
                        ->withInput()->with('error', 'Please fill in required fields');
        }
       DB::beginTransaction();
       try{
        ServiceChargePaymentHistory::payServiceCharge($request->all());
         DB::commit();
    }
  catch(exception $e){
             DB::rollback();
            return back()->withInput()->with('error', 'An error occured. Please try again');
        }
        return redirect()->route('asset.index')->with('success', 'Asset added successfully');
    }

    public function getServiveChargePaymentHistory(Request $request){
              $service_charge_payment_histories = ServiceChargePaymentHistory::join('tenants','tenants.id','=','service_charge_payment_histories.tenant')
          ->join('service_charges','service_charges.id','=','service_charge_payment_histories.service_charge')
         ->where('service_charge_payment_histories.user_id', getOwnerUserID())
         ->select('service_charge_payment_histories.*',
            DB::raw('CONCAT(tenants.designation, " ", tenants.firstname, " ", tenants.lastname) as tenantDetail'),
            'tenants.*','service_charges.*')
         ->orderby('service_charge_payment_histories.created_at','desc')
         ->get();
        // dd($service_charge_payment_histories);
          return view('new.admin.assetServiceCharge.paymentHistories', compact('service_charge_payment_histories'));
    }
}
