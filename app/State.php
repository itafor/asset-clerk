<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class State extends Model
{
    protected $table = 'states';

    static function getNigerianStates()
    {
        return State::where('country_id', 160)->pluck('name', 'id');
    }

    public function city()
    {
        return $this->hasMany('App\City', 'city_id');
    }
}
