<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\TenantRent;

class Unit extends Model
{
    protected $fillable = [
        'asset_id', 'category_id', 'quantity', 'standard_price', 'quantity_left', 'uuid',
        'property_type_id'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
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
        ->whereRaw('due_date > CURDATE()')->latest()->with('tenant', 'asset')->first();
    }

    public function getTenant()
    {
        $rental = TenantRent::where('unit_uuid', $this->uuid)
        ->whereRaw('due_date > CURDATE()')->latest()->with('tenant')->first();
        return $rental->tenant;
    }

    public function getProperty()
    {
        $rental = TenantRent::where('unit_uuid', $this->uuid)
        ->whereRaw('due_date > CURDATE()')->latest()->with('asset.landlord')->first();
        return $rental->asset;
    }
}
