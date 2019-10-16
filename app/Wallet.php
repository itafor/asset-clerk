<?php

namespace App;

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

     public static function saveWallHistory($tenant_id,$previous_balance,$new_balance,$amount){
     	WalletHistory::create([
     		'tenant_id' => $tenant_id,
    		'user_id' => getOwnerUserID(),
    		'previous_balance' => $previous_balance,
    		'new_balance' => $new_balance,
    		'amount' => $amount,
    		'transaction_type' => 'Deposit',
     	]);
     }

     public static function updateWallet($data){
     	self::where('tenant_id',$data['tenant_id'])
     		->where('user_id',getOwnerUserID())
     		->update([
     		'amount' => $data['new_balance'],
     	]);

     self::saveWallHistory($data['tenant_id'],$data['previous_balance'],$data['new_balance'],$data['amount']);
     }
}
