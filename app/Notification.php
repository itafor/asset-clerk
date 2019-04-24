<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $fillable = [
        'notification_type', 'for_id', 'status', 'from_id'
    ];
}
