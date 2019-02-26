<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;

class Asset extends Model
{
    protected $fillable = [
        'description', 'category', 'quantity_added','quantity_left ','price','address','agent_id','country', 'state'
    ];

    public function Tenant(){
        return $this->hasMany('App\Tenant');
    }
//    public function Tenant(){
//        return $this->BelongsToMany('App\Tenant', 'asset_tenant', 'asset_id', 'tenant_id')->withPivot('description',
//            'address', 'price','occupation_date');
//    }
}