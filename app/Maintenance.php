<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Maintenance extends Model
{
    
    protected $fillable = [
        'tenant_id', 'building_section', 'reported_date','description','status',
        'asset_description_uuid', 'uuid', 'user_id', 'category'
    ];

    public function Tenant(){
        return $this->belongsTo(Tenant::class);
    }
    
    public function buildingSection(){
        return $this->belongsTo(BuildingSection::class,'building_section', 'id');
    }

    public function asset()
    {
        return $this->belongsTo(Asset::class, 'asset_description_uuid', 'uuid');
    }

    public function categoryy(){
        return $this->belongsTo(Category::class,'category', 'id');
    }

    public static function createNew($data)
    {
        self::create([
            'tenant_id' => $data['customer'],
            'building_section' => $data['building_section'],
            'reported_date' => formatDate($data['reported_date'], 'd/m/Y', 'Y-m-d'),
            // 'category' => $data['category'],
            'description' => $data['fault_description'],
            'asset_description_uuid' => $data['asset_description'],
            'status' => $data['status'],
            'uuid' => generateUUID(),
            'user_id' => getOwnerUserID()
        ]); 
    }

    public static function updateMintenance($data)
    {
        self::where('uuid', $data['uuid'])->update([
            'tenant_id' => $data['customer'],
            'building_section' => $data['building_section'],
            'reported_date' => formatDate($data['reported_date'], 'd/m/Y', 'Y-m-d'),
            // 'category' => $data['category'],
            'description' => $data['fault_description'],
            'asset_description_uuid' => $data['asset_description'],
        ]);
    }
}
