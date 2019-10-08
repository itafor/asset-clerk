<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AssetServiceCharge extends Model
{
    protected $fillable = [
        'asset_id', 'service_charge_id', 'price', 'user_id','tenant_id','status'
    ];

    public function asset()
    {
        return $this->belongsTo('App\Asset');
    }
   
    public function serviceCharge()
    {
        return $this->belongsTo('App\ServiceCharge');
    }
}
