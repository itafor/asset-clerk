<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Maintenance extends Model
{
    
protected $fillable = [
        'tenant_id', 'building_section', 'reported_date','description','status'
    ];
    public function Tenant(){
        return $this->belongsTo('App\Tenant');
    }
}
