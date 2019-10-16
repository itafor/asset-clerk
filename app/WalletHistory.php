<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WalletHistory extends Model
{
     protected $fillable = ['tenant_id','user_id','previous_balance','new_balance','amount','transaction_type'];
}
