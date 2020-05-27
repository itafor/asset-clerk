<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PropertyFeature extends Model
{
     protected $fillable = [
        'asset_id', 'feature', 'user_id'
    ];
    public function propFeature() 
    {
        return $this->belongsTo(AssetFeature::class, 'feature', 'id');
    }
}
