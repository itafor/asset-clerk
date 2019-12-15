<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SubPaymentMetalDatas extends Model
{
     protected $fillable=['user_id','email','amount','subscription_uuid','transaction_uuid','payment_reference','plan_id','bank_transfer_reference'];
}
