<?php

namespace App\Http\Controllers;

use App\Wallet;
use App\WalletHistory;
use DB;
use Illuminate\Http\Request;
use Validator;

class WalletController extends Controller
{

public function index(Request $request){
return view('new.admin.wallet.fund_wallet');
}

public function fetchBalance($tenant_id){
	$tenantBal = Wallet::where('tenant_id',$tenant_id)
	->where('user_id',getOwnerUserID())->first();
	if($tenantBal){
		return $tenantBal;
	}else{
		return response()->json(['balance'=>0]);
	}
}
 public function fetchTenantWallet(){

 	$tenantWallets = Wallet::join('tenants','tenants.id','=','wallets.tenant_id')
 	->where('wallets.user_id',getOwnerUserID())
    ->select('wallets.*',
            DB::raw('CONCAT(tenants.designation, " ", tenants.firstname, " ", tenants.lastname) as tenantDetail'))
 	->get();

 	return view('new.admin.wallet.list-wallet',compact('tenantWallets'));
 }

 public function fetchWalletHistory(){
 	$tenantWalletsHistories = WalletHistory::join('tenants','tenants.id','=','wallet_histories.tenant_id')
 	->where('wallet_histories.user_id',getOwnerUserID())
    ->select('wallet_histories.*',
            DB::raw('CONCAT(tenants.designation, " ", tenants.firstname, " ", tenants.lastname) as tenantDetail'))
 	->get();

 	return view('new.admin.wallet.wallet-history',compact('tenantWalletsHistories'));
 }
    public function fundWallet(Request $request){
    	  $validator = validator::make($request->all(),[
        'tenant_id' => 'required',
        'amount' => 'required',
        'previous_balance' => 'required',
        'new_balance' => 'required',
        ]);
    if($validator->fails()){
            return back()->withErrors($validator)
                        ->withInput()->with('error', 'Please fill in required fields');
        }
       DB::beginTransaction();
       try{
       	$tenant = Wallet::where('tenant_id',$request->tenant_id)
     		                ->where('user_id',getOwnerUserID())->first();
     if(!$tenant){
     	 Wallet::deposite($request->all());
         DB::commit();
     		}else{
     	 Wallet::updateWallet($request->all());	
     	  DB::commit();
     		}                
     	}
        
  catch(exception $e){
             DB::rollback();
            return back()->withInput()->with('error', 'An error occured. Please try again');
        }
        return redirect()->route('asset.index')->with('success', 'Wallet successfully funded');
    }
}
