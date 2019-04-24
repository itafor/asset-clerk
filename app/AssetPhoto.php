<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AssetPhoto extends Model
{
    public $fillable = [
        'asset_id', 'image_url'
    ];
}
