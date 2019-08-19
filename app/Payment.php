<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\RentDue;
use App\Unit;
use Carbon\Carbon;

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
        $rentalID = env('RENTAL_ID'); // Payment Type: Rental
        if($data['payment_type'] == $rentalID){ //Payment is rental
            $unit = Unit::where('uuid', $data['unit'])->first();
            $rental = $unit->getRental();
            $rent = RentDue::where([
                ['tenant_uuid', $unit->getTenant()->uuid],
                ['rent_id', $rental->id],
                ['status', 'pending'],
            ])->latest()->first();

            if($rent){
                $rent->amount_paid += $data['amount'];
                if($rent->balance == $data['amount']){
                    $rent->status = 'paid';
                    $rent->balance = 0;
                    $rent->payment_date = formatDate($data['payment_date'], 'd/m/Y', 'Y-m-d');
                    self::addNewRentPayment($rental, $data);
                } elseif($rent->balance > $data['amount']){
                    $rent->balance -= $data['amount'];
                }
                $rent->save();
            }
        }

        return self::create([
            'uuid' => generateUUID(),
            'user_id' => getOwnerUserID(),
            'payment_type_id' => $data['payment_type'],
            'asset_unit_uuid' => $data['unit'],
            'amount' => $data['amount'],
            'payment_mode_id' => $data['payment_mode'],
            'payment_description' => $data['description'],
            'service_charge_id' => $data['service_charge'],
            'payment_date' => formatDate($data['payment_date'], 'd/m/Y', 'Y-m-d'),
        ]);
    }

    public static function addNewRentPayment($rental, $data)
    {
        $date = Carbon::parse($rental->due_date);
        $dueDate = $date->addYears($rental->duration);
        RentDue::create([
            'status' => 'pending',
            'tenant_uuid' => $rental->tenant_uuid,
            'due_date' => $dueDate,
            'amount' => $rental->price,
            'balance' => $rental->price,
            'rent_id' => $rental->id,
            'user_id' => getOwnerUserID(),
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
            'payment_date' => formatDate($data['payment_date'], 'd/m/Y', 'Y-m-d'),
        ]);
    }
}
