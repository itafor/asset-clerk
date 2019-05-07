<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AssetServiceCharge extends Model
{
    protected $fillable = [
        'asset_id', 'service_charge_id', 'price', 'user_id'
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
