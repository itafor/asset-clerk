<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Unit extends Model
{
    protected $fillable = [
        'asset_id', 'category_id', 'quantity', 'standard_price'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
