<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TenantProperty extends Model
{
	use SoftDeletes;
	
    protected $fillable=['user_id','uuid','property_uuid','unit_uuid','tenant_uuid','property_proposed_pice'];
}
