<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    protected $table = 'cities';

    static function getCity($id)
    {
        return City::where('state_id', $id)->pluck('name', 'id');
    }

    public function state()
    {
        return $this->belongsTo('App\State', 'state_id');
    }
}

