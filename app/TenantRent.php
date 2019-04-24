<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TenantRent extends Model
{

    use SoftDeletes;

    protected $fillable = [
        'tenant_id', 'asset_uuid', 'price', 'rental_date', 'user_id', 'status', 'uuid'
    ];

    public function tenant()
    {
        return $this->belongsTo(Tenant::class);
    }

    public function asset()
    {
        return $this->belongsTo(Asset::class,'asset_uuid', 'uuid');
    }

    public static function createNew($data)
    {
        self::create([
            'tenant_id' => $data['tenant'],
            'asset_uuid' => $data['asset_description'],
            'price' => $data['standard_price'],
            'rental_date' => formatDate($data['date'], 'm/d/Y', 'Y-m-d'),
            'uuid' => generateUUID(),
            'user_id' => auth()->id(),
            'status' => 'pending'
        ]);
    }
}
