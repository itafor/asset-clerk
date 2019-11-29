<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AssetServiceCharge extends Model
{
    protected $fillable = [
        'asset_id', 'service_charge_id', 'price','balance','payment_status','startDate','dueDate','user_id','tenant_id','status','description'
    ];


    public function asset()
    {
        return $this->belongsTo('App\Asset');
    }

    public function tenant()
    {
        return $this->belongsTo('App\Tenant');
    }
   
    public function serviceCharge()
    {
        return $this->belongsTo('App\ServiceCharge');
    }


    public function tenantsServiceCharge($id){
            
           $tenants = self::find($id);
          $tenants = $tenants->tenant_id;
          $tenants_ids=explode(' ',$tenants); 

         $tenantsDetails=array();
          foreach ($tenants_ids as $key => $id) {
         $tenantsDetails[] = Tenant::where('id',(int)$id)->get();
          }
          return $tenantsDetails;
        }


  

    public function tenants(){
      return $this->hasMany(Tenant::class,'tenant_id');
    }


}
