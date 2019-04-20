<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Guarantor extends Model
{
    protected $fillable = [
        'designation', 'occupation', 'firstname','lastname','address','phone','tenant_id'
    ];
}
