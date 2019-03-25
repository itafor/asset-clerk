<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;
use App\AssetPhoto;
use Illuminate\Database\Eloquent\SoftDeletes;

class Asset extends Model
{

    use SoftDeletes;

    protected $fillable = [
        'description', 'category_id', 'quantity_added','quantity_left ','price',
        'address','agent_id','country', 'state', 'features',
        'quantity_occupied',
        'landlord_id',
        'country_id',
        'state_id',
        'city_id',
        'detailed_information',
        'building_age_id',
        'bedrooms',
        'bathrooms',
        'uuid',
        'user_id'
    ];

    public function Tenant(){
        return $this->hasMany('App\Tenant');
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function photos()
    {
        return $this->hasMany(AssetPhoto::class);
    }

//    public function Tenant(){
//        return $this->BelongsToMany('App\Tenant', 'asset_tenant', 'asset_id', 'tenant_id')->withPivot('description',
//            'address', 'price','occupation_date');
//    }

    public static function createNew($data)
    {
        $asset = self::create([
            'description' => $data['description'],
            'quantity_added' => $data['quantity'],
            'quantity_left' => $data['quantity'],
            'category_id' => $data['category'],
            'price' => $data['standard_price'],
            'landlord_id' => $data['landlord'],
            'country_id' => $data['country'],
            'state_id' => $data['state'],
            'city_id' => $data['city'],
            'detailed_information' => $data['detailed_information'],
            'address' => $data['address'],
            'building_age_id' => $data['building_age'],
            'bedrooms' => $data['bedrooms'],
            'bathrooms' => $data['bathrooms'],
            'features' => implode(',',$data['features']),
            'uuid' => generateUUID(),
            'user_id' => auth()->id()
        ]); 

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

    public static function updateAsset($data)
    {
        self::where('uuid', $data['uuid'])->update([
            'description' => $data['description'],
            'quantity_added' => $data['quantity'],
            'category_id' => $data['category'],
            'price' => $data['standard_price'],
            'landlord_id' => $data['landlord'],
            'country_id' => $data['country'],
            'state_id' => $data['state'],
            'city_id' => $data['city'],
            'detailed_information' => $data['detailed_information'],
            'address' => $data['address'],
            'building_age_id' => $data['building_age'],
            'bedrooms' => $data['bedrooms'],
            'bathrooms' => $data['bathrooms'],
            'features' => implode(',',$data['features'])
        ]); 

        $asset = self::where('uuid', $data['uuid'])->first();

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