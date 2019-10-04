<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\AssetPhoto;
use App\AssetServiceCharge;
use App\Unit;
use Illuminate\Database\Eloquent\SoftDeletes;

class Asset extends Model
{

    use SoftDeletes;

    protected $fillable = [
        'description', 'category_id', 'quantity_added','quantity_left ','price',
        'address','agent_id','country', 'state', 'features',
        'quantity_occupied', 'commission',
        'landlord_id',
        'country_id',
        'state_id',
        'city_id',
        'detailed_information',
        'building_age_id',
        'bedrooms',
        'bathrooms',
        'uuid', 'construction_year',
        'user_id',
    ];

    public function Tenant(){
        return $this->hasMany(Tenant::class);
    }
    
    public function Landlord(){
        return $this->belongsTo(Landlord::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function photos()
    {
        return $this->hasMany(AssetPhoto::class);
    }
    
    public function units()
    {
        return $this->hasMany(Unit::class);
    }
    
    public function serviceCharges()
    {
        return AssetServiceCharge::where('asset_id', $this->id)->get();
    }

//    public function Tenant(){
//        return $this->BelongsToMany('App\Tenant', 'asset_tenant', 'asset_id', 'tenant_id')->withPivot('description',
//            'address', 'price','occupation_date');
//    }

    public static function createNew($data)
    {
        $asset = self::create([
            'commission' => $data['commission'],
            'description' => $data['description'],
            'landlord_id' => $data['landlord'],
            'country_id' => $data['country'],
            'state_id' => $data['state'],
            'city_id' => $data['city'],
            'detailed_information' => $data['detailed_information'],
            'address' => $data['address'],
            'construction_year' => $data['construction_year'],
            'features' => isset($data['features']) ? implode(',',$data['features']) : null,
            'uuid' => generateUUID(),
            'user_id' => getOwnerUserID()
        ]); 

        self::createUnit($data,$asset);
        self::addPhoto($data,$asset); 
        // self::addServiceCharge($data,$asset);
    }

    public static function updateAsset($data)
    {
        self::where('uuid', $data['uuid'])->update([
            'commission' => $data['commission'],
            'description' => $data['description'],
            'landlord_id' => $data['landlord'],
            'country_id' => $data['country'],
            'state_id' => $data['state'],
            'city_id' => $data['city'],
            'detailed_information' => $data['detailed_information'],
            'address' => $data['address'],
            'construction_year' => $data['construction_year'],
            'features' => implode(',',$data['features'])
        ]); 

        $asset = self::where('uuid', $data['uuid'])->first();

        if(isset($data['photos'])){
            self::addPhoto($data,$asset);
        }
        //self::removeUnits($asset);
        self::updateUnits($data,$asset);
        // self::addServiceCharge($data,$asset);
    }

    public static function removeUnits($asset)
    {
        $asset->units()->delete();
    }

    public static function createUnit($data,$asset)
    {
        foreach($data['unit'] as $unit){
            Unit::create([
                'asset_id' => $asset->id,
                'user_id' => getOwnerUserID(),
                'category_id' => $unit['category'],
                'quantity' => $unit['quantity'],
                'quantity_left' => $unit['quantity'],
                'standard_price' => $unit['standard_price'],
                'property_type_id' => $unit['property_type'],
                'uuid' => generateUUID(),
            ]);
        }
    }
    
    public static function updateUnits($data,$asset)
    {
        foreach($data['unit'] as $key => $unit){
            $u = Unit::where('uuid', $key)->first();
            if($u){
                $u->category_id = $unit['category'];
                $u->standard_price = $unit['standard_price'];
                $u->property_type_id = $unit['property_type'];
                $u->quantity = $unit['quantity'];
                $u->quantity_left = ($unit['quantity'] - $u->quantity) + $u->quantity_left;
                $u->save();
            }
            else{
                Unit::create([
                    'asset_id' => $asset->id,
                    'user_id' => getOwnerUserID(),
                    'category_id' => $unit['category'],
                    'quantity' => $unit['quantity'],
                    'quantity_left' => $unit['quantity'],
                    'standard_price' => $unit['standard_price'],
                    'property_type_id' => $unit['property_type'],
                    'uuid' => generateUUID(),
                ]);
            }
        }
    }
    
    public static function addServiceCharge($data,$asset)
    {
        AssetServiceCharge::where('asset_id', $asset->id)->delete();
        foreach($data['service'] as $unit){
            AssetServiceCharge::create([
                'asset_id' => $asset->id,
                'service_charge_id' => $unit['service_charge'],
                'price' => $unit['price'],
                'user_id' => getOwnerUserID()
            ]);
        }
    }

    public static function addPhoto($data,$asset)
    {
        if(isset($data['photos'])){
            foreach($data['photos'] as $photo){
            $path = uploadImage($photo);
            if($path){
                AssetPhoto::create([
                    'asset_id' => $asset->id,
                    'image_url' => $path
                ]);
            }
        }
        }
    }
}