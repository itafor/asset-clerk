<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TenantDocument extends Model
{
	use SoftDeletes;
    protected $fillable = [
        'user_id', 'tenant_id', 'path','image_url','name'
    ];
}
