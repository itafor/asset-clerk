<?php

namespace App;

use App\AssetServiceCharge;
use App\ServiceCharge;
use App\Tenant;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
	
class TenantServiceCharge extends Model
{
	 use SoftDeletes;
	 
    protected $fillable = ['tenant_id','asc_id','service_chargeId','user_id','bal','startDate','dueDate'];

 public function asc()
    {
        return $this->belongsTo('App\AssetServiceCharge','asc_id');
    } 

 public function myServiceCharges($id){
      //return $this->hasMany(AssetServiceCharge::class);
 	return AssetServiceCharge::find($id);
    }

    public function myTenants($id){
      //return $this->hasMany(AssetServiceCharge::class);
 	return Tenant::find($id);
    }

     public function myServiceCharge($id){
      //return $this->hasMany(AssetServiceCharge::class);
 	return ServiceCharge::find($id);
    }
}
