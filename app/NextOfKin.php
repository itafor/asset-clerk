<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NextOfKin extends Model
{
    protected $fillable = [
        'firstname', 'lastname', 'address','phone','tenant_id'
    ];
}
