<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;
use App\Unit;
use App\RentDue;
use DB;

class TenantRent extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'tenant_id', 'asset_uuid', 'price', 'rental_date', 'user_id', 'status', 'uuid',
        'tenant_uuid', 'unit_uuid', 'duration', 'duration_type', 'due_date'
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
        $rentalDate = formatDate($data['date'], 'm/d/Y', 'Y-m-d');
        $date = Carbon::parse($rentalDate);
        $dueDate = $date->addYears($data['duration']);

        DB::beginTransaction();

        try{
            $rental = self::create([
                'tenant_uuid' => $data['tenant'],
                'asset_uuid' => $data['property'],
                'unit_uuid' => $data['unit'],
                'price' => $data['price'],
                'rental_date' => $rentalDate,
                'due_date' => $dueDate,
                'uuid' => generateUUID(),
                'user_id' => getOwnerUserID(),
                'status' => 'pending',
                'duration' => $data['duration'],
                'duration_type' => 'year',
            ]);
            self::reduceUnit($data);
            self::addNextPayment($data, $rental);
            DB::commit();
        }
        catch(Exception $e)
        {
            DB::rollback();
        }
    }

    public static function addNextPayment($data, $rental)
    {
        RentDue::create([
            'status' => 'pending',
            'tenant_uuid' => $rental->tenant_uuid,
            'due_date' => $rental->due_date,
            'amount' => $rental->price,
            'rent_id' => $rental->id,
            'user_id' => auth()->id(),
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
}
