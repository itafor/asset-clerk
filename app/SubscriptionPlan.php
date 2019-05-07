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
        'uuid', 'name', 'status', 'properties', 'sub_accounts', 'service_charge'
    ];

    /*public function category()
    {
        return $this->belongsTo(Category::class);
    }*/
}
