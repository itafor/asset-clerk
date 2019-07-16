<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Landlord extends Model
{

    use SoftDeletes;

    protected $fillable = [
        'designation', 'gender', 'firstname','lastname','date_of_birth','occupation','address','state','phone',
        'agent_id','referral_code','photo','user_id', 'asset_id', 'asset_description', 'price', 'asset_address',
        'country_id', 'state_id', 'city_id', 'uuid', 'user_id', 'email'
    ];
    public function Asset(){
        return $this->hasMany('App\Asset');
    }
    public function Maintenance(){
        return $this->hasMany('App\Maintenance');
    }

    public function name()
    {
        return $this->lastname.' '.$this->firstname;
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

    public static function updateLandlord($data)
    {
        $landlord = self::where('uuid', $data['uuid'])->first();
        $landlord->designation = $data['designation'];
        $landlord->gender = $data['gender'];
        $landlord->firstname = $data['firstname'];
        $landlord->lastname = $data['lastname'];
        $landlord->date_of_birth = formatDate($data['date_of_birth'], 'd/m/Y', 'Y-m-d');
        $landlord->occupation = $data['occupation'];
        $landlord->country_id = $data['country'];
        $landlord->state_id = $data['state'];
        $landlord->city_id = $data['city'];
        $landlord->address = $data['address'];
        $landlord->email = $data['email'];
        $landlord->phone = $data['contact_number'];
        if(isset($data['passport'])){
            $passport = uploadImage($data['passport']);
            if($passport){
                $landlord->photo = $passport;
            }
        }
        $landlord->save();
    }
}
