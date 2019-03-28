<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;

class AssetTenant extends Model
{
    protected $fillable = [
        'tenant_id', 'asset_id', 'description', 'address', 'date'
    ];
    public function Tenant(){
        return $this->hasMany('App\Tenant');
    }
    public function Asset(){
        return $this->hasMany('App\Asset');
    }
    public function getName($id){
        $categoryName = \App\Category::find($id);
        return $categoryName->name;
    }
    public function getStatus($id){
        $rentStatus = \App\RentDue::find($id);
        dd($rentStatus);
        return $rentStatus->status;
    }
}