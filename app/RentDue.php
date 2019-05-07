<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RentDue extends Model
{
    protected $fillable = [
        'tenant_uuid', 'status', 'due_date','payment_date','amount','rent_id',
        'user_id'
    ];


}
