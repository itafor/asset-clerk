<?php

namespace App\Http\Controllers;

use App\TenantServiceCharge;
use Illuminate\Http\Request;

class AssetServiceChargeController extends Controller
{
    public function getDebtors(){
    	  $debtors = TenantServiceCharge::join('asset_service_charges', 'asset_service_charges.id', '=', 'tenant_service_charges.asc_id')
    	  ->join('tenants','tenants.id','=','tenant_service_charges.tenant_id')
    	  ->join('service_charges','service_charges.id','=','tenant_service_charges.service_chargeId')
         ->where('tenant_service_charges.user_id', getOwnerUserID())
         ->select('tenant_service_charges.*','asset_service_charges.*','tenants.*','service_charges.*')
         ->get();
//dd($debtors);
          return view('new.admin.assetServiceCharge.debtors', compact('debtors'));
         
    }

    public function payServiveCharge(){
    	return view('new.admin.assetServiceCharge.service-charge-payment');
    }

    public function getTenantServiceCharge($id){
         $tenantServiceCharges = TenantServiceCharge::join('asset_service_charges', 'asset_service_charges.id', '=', 'tenant_service_charges.asc_id')
          ->join('tenants','tenants.id','=','tenant_service_charges.tenant_id')
          ->join('service_charges','service_charges.id','=','tenant_service_charges.service_chargeId')
         ->where('tenant_service_charges.user_id', getOwnerUserID())
         ->where('tenants.id', $id)
         ->select('service_charges.*')
         ->get();
//dd($tenantServiceCharges);
         return $tenantServiceCharges;
    }


    public function getServiceChargeAmount($id,$tenantId){
        $ServiceChargesAmount = TenantServiceCharge::join('asset_service_charges', 'asset_service_charges.id', '=', 'tenant_service_charges.asc_id')
          ->join('tenants','tenants.id','=','tenant_service_charges.tenant_id')
          ->join('service_charges','service_charges.id','=','tenant_service_charges.service_chargeId')
         ->where('tenant_service_charges.user_id', getOwnerUserID())
        ->where('tenant_service_charges.service_chargeId', $id)
        ->where('tenant_service_charges.tenant_id', $tenantId)
         ->select('service_charges.*','asset_service_charges.*','tenant_service_charges.*')
         ->get();
//dd($tenantServiceCharges);
         return $ServiceChargesAmount;
    }
}
