<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RentDue extends Model
{
    

protected $fillable = [
        'tenant_id', 'status', 'due_date','payment_date','amount','rentType'
    ];


}
