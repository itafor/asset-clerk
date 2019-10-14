<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AssetServiceCharge extends Model
{
    protected $fillable = [
        'asset_id', 'service_charge_id', 'price','dueDate','user_id','tenant_id','status'
    ];

    public function asset()
    {
        return $this->belongsTo('App\Asset');
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

}
