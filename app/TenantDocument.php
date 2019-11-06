<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TenantDocument extends Model
{
    protected $fillable = [
        'user_id', 'tenant_id', 'path','image_url','name'
    ];
}
