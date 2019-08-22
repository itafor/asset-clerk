<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tenant extends Model
{

    use SoftDeletes;

    protected $fillable = [
        'designation', 'gender', 'firstname','lastname','date_of_birth','occupation','address','state','phone',
        'agent_id','referral_code','photo','user_id', 'asset_id', 'asset_description', 'price', 'asset_address','country',
        'email', 'office_country_id', 'office_state_id', 'office_city_id', 'country_id', 'state_id', 'city_id', 'uuid', 'occupation_id'
    ];

    public function Asset()
    {
        return $this->BelongsToMany('App\Asset');
    }

    public function Maintenance()
    {
        return $this->hasMany('App\Maintenance');
    }

    public function occupationName()
    {
        return $this->belongsTo(Occupation::class, 'occupation_id');
    }

    public function User()
    {
        return $this->hasMany('App\User', 'user_id');
    }

    public function name()
    {
        return $this->designation.' '.$this->lastname.' '.$this->firstname;
    }

    public static function createNew($data)
    {
        $passport = uploadImage($data['passport']);

        self::create([
            'designation' => $data['designation'],
            'gender' => $data['gender'],
            'firstname' => $data['firstname'],
            'lastname' => $data['lastname'],
            'date_of_birth' => formatDate($data['date_of_birth'], 'd/m/Y', 'Y-m-d'),
            'occupation' => $data['occupation'],
            // 'occupation_id' => $data['occupation'],
            'office_country_id' => $data['office_country'],
            'office_state_id' => $data['office_state'],
            'office_city_id' => $data['office_city'],
            'country_id' => $data['country'],
            'state_id' => $data['state'],
            'city_id' => $data['city'],
            'address' => $data['address'],
            'email' => $data['email'],
            'phone' => $data['contact_number'],
            'photo' => $passport,
            'uuid' => generateUUID(),
            'user_id' => getOwnerUserID()
        ]);
    }

    public static function updateTenant($data)
    {
        $tenant = self::where('uuid', $data['uuid'])->first();
        $tenant->designation = $data['designation'];
        $tenant->gender = $data['gender'];
        $tenant->firstname = $data['firstname'];
        $tenant->lastname = $data['lastname'];
        $tenant->date_of_birth = formatDate($data['date_of_birth'], 'd/m/Y', 'Y-m-d');
        $tenant->occupation = $data['occupation'];
        // $tenant->occupation_id = $data['occupation'];
        $tenant->office_country_id = $data['office_country'];
        $tenant->office_state_id = $data['office_state'];
        $tenant->office_city_id = $data['office_city'];
        $tenant->country_id = $data['country'];
        $tenant->state_id = $data['state'];
        $tenant->city_id = $data['city'];
        $tenant->address = $data['address'];
        $tenant->email = $data['email'];
        $tenant->phone = $data['contact_number'];
        if(isset($data['passport'])){
            $passport = uploadImage($data['passport']);
            if($passport){
                $tenant->photo = $passport;
            }
        }
        $tenant->save();
    }
}
