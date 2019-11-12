<?php

namespace App;

use App\TenantRent;
use Illuminate\Database\Eloquent\Model;

class Unit extends Model
{
    protected $fillable = [
        'asset_id','user_id','plan_id','category_id', 'quantity', 'standard_price', 'quantity_left', 'uuid',
        'property_type_id'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

     public function asset()
    {
        return $this->belongsTo(Asset::class, 'asset_id');
    }
    
    public function propertyType()
    {
        return $this->belongsTo(PropertyType::class);
    }

    public function isRented()
    {
        $rental = TenantRent::where('unit_uuid', $this->uuid)
        ->whereRaw('due_date > CURDATE()')->latest()->first();
        if($rental){
            return true;
        }
        else{
            return false;
        }
    }

    public function getRental() 
    {
        return TenantRent::where('unit_uuid', $this->uuid)
       ->latest()->with('tenant', 'asset')->first();
    }

    public function getTenant()
    {
        $rental = TenantRent::where('unit_uuid', $this->uuid)
        ->latest()->with('tenant')->first();
         if($rental){
        return $rental->tenant;
        }
    }

    public function getProperty()
    {
        $rental = TenantRent::where('unit_uuid', $this->uuid)
       ->latest()->with('asset.landlord')->first();
        
        if($rental){
        return $rental->asset;
        }
    }

    public function rentPayment($unit_uuid){
        $rents = TenantRent::where('unit_uuid', $unit_uuid)
      ->get();
        
        if($rents){
            foreach ($rents as $key => $rent) {
                   return [
            'balance' => $rent->balance,
            'amount' => $rent->amount,
        ];
            }

        }
    }
}
