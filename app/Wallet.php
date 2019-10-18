<?php

namespace App;

use App\AssetServiceCharge;
use App\TenantServiceCharge;
use App\WalletHistory;
use Illuminate\Database\Eloquent\Model;

class Wallet extends Model
{
    protected $fillable = ['tenant_id','user_id','amount'];

    public static function deposite($data){
    	self::create([
    		'tenant_id' => $data['tenant_id'],
    		'user_id' => getOwnerUserID(),
    		'amount' => $data['amount'],
    	]);

    	self::saveWallHistory($data['tenant_id'],$data['previous_balance'],$data['new_balance'],$data['amount']);
    }

     public static function saveWallHistory($tenant_id,$previous_balance,$new_balance,$amount,$transactionType='Deposit'){
     	WalletHistory::create([
     		'tenant_id' => $tenant_id,
    		'user_id' => getOwnerUserID(),
    		'previous_balance' => $previous_balance,
    		'new_balance' => $new_balance,
    		'amount' => $amount,
    		'transaction_type' => $transactionType,
     	]);
     }

     public static function updateWallet($tenant_id,$previous_balance,$new_balance,$amount,$transactionType='Deposit'){
     	self::where('tenant_id',$tenant_id)
     		->where('user_id',getOwnerUserID())
     		->update([
     		'amount' => $new_balance,
     	]);

     self::saveWallHistory($tenant_id,$previous_balance,$new_balance,$amount,$transactionType);
     }

public static function updateTenantServiceChargeAmount($tenant_id,$service_charge_Id,$balance,$asc_id){
  $findTSC = TenantServiceCharge::where('tenant_id',$tenant_id)
                        ->where('service_chargeId',$service_charge_Id)
                        ->where('user_id',getOwnerUserID())->first();
                        if($findTSC){
                           $findTSC->bal = $balance;
                           $findTSC->save();
                        }
                        
            if($findTSC->bal == 0){
                $findTSC->delete();
            }

   self::remove_ASC_without_tenant_attashed($asc_id);
   
        }

public static function remove_ASC_without_tenant_attashed($asc_id){
         $fetchTSC= TenantServiceCharge::where('asc_id',$asc_id)
                        ->where('user_id',getOwnerUserID())->get();
                        if(count($fetchTSC) <= 0){
                           self::updateASC($asc_id);
                        }
        }

public static function updateASC($ascId){
    $fetchASC = AssetServiceCharge::where('id',$ascId)
                        ->where('user_id',getOwnerUserID())->first();
        if($fetchASC){
           $fetchASC->status = 0;
           $fetchASC->save();
             }
        }
}
