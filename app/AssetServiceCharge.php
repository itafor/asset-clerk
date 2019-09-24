<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AssetServiceCharge extends Model
{
    protected $fillable = [
        'asset_id', 'service_charge_id', 'price', 'user_id','status'
    ];

    public function asset()
    {
        return $this->belongsTo(Asset::class);
    }
   
    public function serviceCharge()
    {
        return $this->belongsTo(ServiceCharge::class);
    }
}
