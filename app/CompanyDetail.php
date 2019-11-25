<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CompanyDetail extends Model
{
    protected $fillable = ['name','phone','email','logo','logo_url,','user_id','address','uuid'];

    public static function createNew($data)
    {
        $logoUrl = uploadImage($data['company_logo']);

        self::create([
            'name' => $data['company_name'],
            'phone' => $data['company_phone'],
            'email' => $data['company_email'],
            'address' => $data['company_address'],
            'logo_url' => $logoUrl,
            'logo' => $data['company_logo']->getClientOriginalName(),
            'uuid' => generateUUID(),
            'user_id' => getOwnerUserID()
        ]);
    }

       public static function updateCompanyDetail($data)
    {
        $detail = self::where('uuid', $data['uuid'])->first();
        $detail->name = $data['company_name'];
        $detail->phone = $data['company_phone'];
        $detail->email = $data['company_email'];
        $detail->address = $data['company_address'];
  
        if(isset($data['company_logo'])){

         $logoUrl = uploadImage($data['company_logo']);
            if($logoUrl){
                $detail->logo_url = $logoUrl;
                $detail->logo =  $data['company_logo']->getClientOriginalName();
            }
        }
        $detail->save();
    }
}
