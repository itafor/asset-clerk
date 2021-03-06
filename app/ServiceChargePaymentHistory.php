<?php

namespace App;

use App\AssetServiceCharge;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class ServiceChargePaymentHistory extends Model
{



    protected $fillable=['user_id','asset_service_charge_id','tenant','asset_id','service_charge','actualAmount','balance','property','amountPaid','payment_mode','payment_date','durationPaidFor','description'];


   public function unit() 
    {
        return $this->belongsTo(Unit::class, 'unit_id');//To be added to SCPH model
    }



   public function tenants() 
    {
        return $this->belongsTo(Tenant::class, 'tenant');
    }

     public function asset_service_charge() 
    {
        return $this->belongsTo(AssetServiceCharge::class, 'asset_service_charge_id');
    }

    public function getAsset() 
    {
        return $this->belongsTo(Asset::class, 'asset_id');
    }

     public function serviceCharge()
    {
        return $this->belongsTo(ServiceCharge::class,'service_charge');
    }


   public static function payServiceCharge($data){

  $payment = 	self::create([
   			'user_id' => getOwnerUserID(),
        'tenant' => $data['tenant'],
   			'asset_id' => $data['asset_id'],
   			'service_charge' => $data['service_charge'],
   			'actualAmount' => $data['actualAmount'],
   			'balance' => $data['balance'],
   			'property' => $data['property'],
   			'amountPaid' => $data['amountPaid'],
   			'payment_mode' => $data['payment_mode'],
   			'payment_date' => Carbon::parse(formatDate($data['payment_date'], 'd/m/Y', 'Y-m-d')),
   			'durationPaidFor' => $data['durationPaidFor'],
   			'description' => $data['description'],
        'asset_service_charge_id' => $data['asset_service_charge_id'],
   	]);

   	if($data['balance']){
      self::updateTenantSC($data['tenant'],$data['service_charge'],$data['balance']);
   	}
return $payment;
   }

   public static function updateTenantSC($tenantId,$sc_id,$balance){

   	TenantServiceCharge::where('tenant_id',$tenantId)
   	->where('service_chargeId',$sc_id)
   	->update([
      'bal' => $balance,
   		'paymentStatus' => $balance == 0 ? 'Paid' : 'Partly Paid' 
   	]);
   }


   public static function updateAssetServiceCharge($asc_id,$balance){

    $get_asc = AssetServiceCharge::where('id',$asc_id)->first();
    if($get_asc){
      $get_asc->balance = $balance;
      $get_asc->payment_status = $balance == 0 ? 'Paid' : 'Partly Paid';
      $get_asc->save();
    }
   
   }


   public static function removeTenantThatHaveCompletedSCPayment($tenantId, $sc_id){
     $remove = TenantServiceCharge::where('tenant_id',$tenantId)
      ->where('service_chargeId',$sc_id)->first();
      if($remove){
         $remove->delete();
      }
   }
}
