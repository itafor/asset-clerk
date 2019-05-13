<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\TenantRent;
use Webpatser\Uuid\Uuid;

class Transaction extends Model
{
    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $model->uuid = (string) Uuid::generate(4);
        });
    }

    protected $fillable = [
        'uuid', 'user_id', 'plan_id', 'status', 'channel', 'reference', 'amount','provider_reference'
    ];

    /*public function category()
    {
        return $this->belongsTo(Category::class);
    }*/
}
