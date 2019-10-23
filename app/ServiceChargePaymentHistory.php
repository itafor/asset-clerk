<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class ServiceChargePaymentHistory extends Model
{



    protected $fillable=['user_id','tenant','service_charge','actualAmount','balance','property','amountPaid','payment_mode','payment_date','durationPaidFor','description'];


   public function unit() 
    {
        return $this->belongsTo(Unit::class, 'unit_id');//To be added to SCPH model
    }



   public function tenants() 
    {
        return $this->hasMany(Tenant::class, 'tenant');
    }

     public function serviceCharge()
    {
        return $this->hasMany(ServiceCharge::class,'service_charge');
    }


   public static function payServiceCharge($data){

  return 	self::create([
   			'user_id' => getOwnerUserID(),
   			'tenant' => $data['tenant'],
   			'service_charge' => $data['service_charge'],
   			'actualAmount' => $data['actualAmount'],
   			'balance' => $data['balance'],
   			'property' => $data['property'],
   			'amountPaid' => $data['amountPaid'],
   			'payment_mode' => $data['payment_mode'],
   			'payment_date' => Carbon::parse(formatDate($data['payment_date'], 'd/m/Y', 'Y-m-d')),
   			'durationPaidFor' => $data['durationPaidFor'],
   			'description' => $data['description'],
   	]);

   	if($data['balance']){
   		self::updateTenantSC($data['tenant_id'],$data['service_charge_id'],$data['balance']);
   	}

      if($data['balance'] == 0){
         self::removeTenantThatHaveCompletedSCPayment($data['tenant_id'],$data['service_charge_id']);
      }

   }

   public static function updateTenantSC($tenantId, $sc_id,$balance){
   	TenantServiceCharge::where('tenant_id',$tenantId)
   	->where('service_chargeId',$sc_id)
   	->update([
   		'bal' => $balance 
   	]);
   }

   public static function removeTenantThatHaveCompletedSCPayment($tenantId, $sc_id){
     $remove = TenantServiceCharge::where('tenant_id',$tenantId)
      ->where('service_chargeId',$sc_id)->first();
      if($remove){
         $remove->delete();
      }
   }
}
