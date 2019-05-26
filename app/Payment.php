<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Payment extends Model
{
    use SoftDeletes;

    protected $guarded = [];

    protected $dates = [
        'payment_date'
    ];

    public function unit() 
    {
        return $this->belongsTo(Unit::class, 'asset_unit_uuid', 'uuid');
    }

    public function paymentMode()
    {
        return $this->belongsTo(PaymentMode::class);
    }

    public function paymentType()
    {
        return $this->belongsTo(PaymentType::class);
    }
    
    public function serviceCharge()
    {
        return $this->belongsTo(ServiceCharge::class);
    }

    public static function createNew($data) 
    {
        self::create([
            'uuid' => generateUUID(),
            'user_id' => getOwnerUserID(),
            'payment_type_id' => $data['payment_type'],
            'asset_unit_uuid' => $data['unit'],
            'amount' => $data['amount'],
            'payment_mode_id' => $data['payment_mode'],
            'payment_description' => $data['description'],
            'service_charge_id' => $data['service_charge'],
            'payment_date' => formatDate($data['payment_date'], 'm/d/Y', 'Y-m-d'),
        ]);
    }

    public static function updatePayment($data, $serviceChargeID)
    {
        self::where('uuid', $data['payment'])->update([
            'updated_by' => auth()->id(),
            'payment_type_id' => $data['payment_type'],
            'asset_unit_uuid' => $data['unit'],
            'amount' => $data['amount'],
            'payment_mode_id' => $data['payment_mode'],
            'payment_description' => $data['description'],
            'service_charge_id' => $data['payment_type'] == $serviceChargeID ? $data['service_charge'] : null,
            'payment_date' => formatDate($data['payment_date'], 'm/d/Y', 'Y-m-d'),
        ]);
    }
}
