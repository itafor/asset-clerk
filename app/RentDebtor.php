<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RentDebtor extends Model
{
     use SoftDeletes;

    protected $fillable = [
        'asset_uuid','tenantRent_uuid','proposed_price','actual_amount','balance','startDate', 
        'user_id','uuid','tenant_uuid', 'unit_uuid', 'duration', 'duration_type', 'due_date'
    ];

    public function tenant()
    {
        return $this->belongsTo(Tenant::class, 'tenant_uuid', 'uuid');
    }

    public function asset()
    {
        return $this->belongsTo(Asset::class,'asset_uuid', 'uuid');
    }
    
    public function unit()
    {
        return $this->belongsTo(Unit::class,'unit_uuid', 'uuid');
    }
}
