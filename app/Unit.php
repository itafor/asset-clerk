<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\TenantRent;

class Unit extends Model
{
    protected $fillable = [
        'asset_id', 'category_id', 'quantity', 'standard_price', 'quantity_left', 'uuid'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function isRented()
    {
        $rental = TenantRent::where('unit_uuid', $this->uuid)->first();
        if($rental){
            return true;
        }
        else{
            return false;
        }
    }
}
