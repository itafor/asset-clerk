<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RentPayment extends Model
{
     use SoftDeletes;

      protected $fillable = [
        'uuid','tenant_uuid', 'asset_uuid','unit_uuid','tenantRent_uuid',
        'proposed_amount','actual_amount',
        'amount_paid','balance','payment_mode_id',
        'user_id','payment_date','startDate','due_date'
    ];

   public function unit() 
    {
        return $this->belongsTo(Unit::class, 'unit_uuid', 'uuid');
    }

    public function paymentMode()
    {
        return $this->belongsTo(PaymentMode::class);
    }

    public function paymentType()
    {
        return $this->belongsTo(PaymentType::class);
    }



}
