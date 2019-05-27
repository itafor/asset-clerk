<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\TenantRent;
use Webpatser\Uuid\Uuid;

class SubscriptionPlan extends Model
{
    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $model->uuid = (string) Uuid::generate(4);
        });
    }

    protected $fillable = [
        'uuid', 'name', 'status', 'properties', 'sub_accounts', 'service_charge','amount','description'
    ];

    public static function createNew($data)
    {
        self::create([
            'name' => $data['name'],
            'status' => 1,
            'properties' => $data['properties'],
            'sub_accounts' => $data['sub_accounts'],
            'service_charge' => $data['service_charge'],
            'amount' => $data['amount'],
            'description' => $data['description']
        ]);
    }
}
