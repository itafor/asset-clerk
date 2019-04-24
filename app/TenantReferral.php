<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TenantReferral extends Model
{
    protected $fillable = [
        'tenant_id', 'status', 'referred_by','commission','updated_by'
    ];
}
