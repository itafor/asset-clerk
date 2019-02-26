<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BankPayment extends Model
{
    protected $fillable = [
        'tenant_id', 'teller'
    ];
}
