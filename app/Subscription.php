<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Webpatser\Uuid\Uuid;

class Subscription extends Model
{
    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $model->uuid = (string) Uuid::generate(4);
        });
    }

    protected $fillable = [
        'uuid', 'user_id', 'transaction_id', 'start', 'end', 'reference','plan_id','status'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function transaction()
    {
        return $this->belongsTo(Transaction::class);
    }
    
    public function plan()
    {
        return $this->belongsTo(SubscriptionPlan::class, 'plan_id', 'uuid');
    }
}
