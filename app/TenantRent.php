<?php

namespace App;

use App\RentDebtor;
use App\RentDue;
use App\Unit;
use Carbon\Carbon;
use DateInterval;
use DatePeriod;
use DateTime;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TenantRent extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'tenant_id', 'asset_uuid', 'price','amount','startDate', 'user_id', 'status', 'uuid',
        'tenant_uuid', 'unit_uuid', 'duration', 'duration_type', 'due_date','balance'
    ];

    public function tenant()
    {
        return $this->belongsTo(Tenant::class, 'tenant_uuid', 'uuid');
    }

    public function asset()
    {
        return $this->belongsTo(Asset::class,'asset_uuid', 'uuid');
    }
    
    public function unit()
    {
        return $this->belongsTo(Unit::class,'unit_uuid', 'uuid');
    }

    public static function createNew($data)
    {
        //$rentalDate = formatDate($data['date'], 'd/m/Y', 'Y-m-d');
        $startDate = formatDate($data['startDate'], 'd/m/Y', 'Y-m-d');
        $startDate = Carbon::parse($startDate);
        //$dueDate = $date->addYears($data['duration']);
        $dueDate = formatDate($data['due_date'], 'd/m/Y', 'Y-m-d');
        $dueDate = Carbon::parse($dueDate);
           

        $duration = $startDate->diff($dueDate)->days;
        $end_date = (new $startDate)->add(new DateInterval("P{$duration}D") );
        $dd = date_diff($startDate,$end_date);
        $final_duration = $dd->y." years, ".$dd->m." months, ".$dd->d." days";
        

        $rental = self::create([
            'tenant_uuid' => $data['tenant'],
            'asset_uuid' => $data['property'],
            'unit_uuid' => $data['unit'],
            'price' => $data['price'],
            'amount' => $data['amount'],
            'balance' => $data['amount'],
            'startDate' => $startDate,
            'due_date' => $dueDate,//end date
            'uuid' => generateUUID(),
            'user_id' => $data['user_id'] ? $data['user_id'] : getOwnerUserID(),
            'status' => 'pending',
            'duration' => $final_duration,//star date
            'duration_type' => 'days',
        ]);
        self::reduceUnit($data);
        self::addNextPayment($data, $rental);
        self::addToRentDebtor($data,$rental);
        return $rental;
    }

    public static function addNextPayment($data, $rental)
    {
        RentDue::create([
            'status' => 'pending',
            'tenant_uuid' => $rental->tenant_uuid,
            'due_date' => $rental->due_date,
            'amount' => $rental->price,
            'amount_paid' => $rental->amount,
            'balance' => $rental->balance,
            'rent_id' => $rental->id,
            'user_id' => $rental->user_id ? $rental->user_id : getOwnerUserID(),
        ]);
    }

    public static function reduceUnit($data)
    {
        $unit = Unit::where('uuid', $data['unit'])->first();
        $unit->quantity_left -= 1;
        $unit->save();
    }

    /**
     * Delete rental
     * Restore units
     * Delete rent due pending
     */
    public function removeRental()
    {
        $unit = Unit::where('uuid', $this->unit_uuid)->first();
        $unit->quantity_left += 1;
        $unit->save();

        RentDue::where('rent_id', $this->id)->where('status', 'pending')->delete();
        
        $this->delete();
    }

    public static function addToRentDebtor($data, $rental){
    return   RentDebtor::create([
            'tenant_uuid' => $rental->tenant_uuid,
            'asset_uuid' => $rental->asset_uuid,
            'unit_uuid' => $rental->unit_uuid,
            'proposed_price' => $rental->price,
            'actual_amount' => $rental->amount,
            'balance' => $rental->amount,
            'startDate' => $rental->startDate,
            'due_date' => $rental->due_date,//end date
            'uuid' => generateUUID(),
            'user_id' => $rental->user_id ? $rental->user_id : getOwnerUserID(),
            'tenantRent_uuid' => $rental->uuid,
            'duration' => $rental->duration,
        ]);

    }
}
