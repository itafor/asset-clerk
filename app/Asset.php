<?php

namespace App;

use App\AssetPhoto;
use App\AssetServiceCharge;
use App\TenantServiceCharge;
use App\Unit;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Input;

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
        //AssetServiceCharge::where('asset_id', $asset->id)->delete();

        $tenantIds=$data['tenant_id'];
        $startDate = $data['startDate'];
        $dueDate = $data['dueDate'];
        $services = $data['service'];

        $allTenantServiceCharges=TenantServiceCharge::where('user_id',getOwnerUserID())->get();
        
       if($allTenantServiceCharges){
            foreach ($allTenantServiceCharges as $key => $aTSC) {
                foreach ($services as $key => $service) {
                    foreach ($tenantIds as $key => $tenantId) {

                    if(
                            $tenantId == $aTSC->tenant_id
                        &&  $service['service_charge'] == $aTSC->service_chargeId
                        &&  $startDate == Carbon::parse($aTSC->startDate)->format('d/m/Y')
                         &&  $dueDate == Carbon::parse($aTSC->dueDate)->format('d/m/Y')
                    ){
                         return back()->withInput()->with('error','A tenant has already been added to this service Charge for the specified start and due date, Check and try again!!');
                    }

                    }
                }
               
            }
        }

  if($dueDate < $startDate){
        return back()->withInput()->with('error','End Date cannot be less than start date');
    }

        $service_chargeIDs=$data['service'];
        $tenants_ids = implode(' ', Input::get('tenant_id'));//convert array to string
                foreach($data['service'] as $unit){
        $asc =  AssetServiceCharge::create([
                'asset_id' => $asset->id,
                'service_charge_id' => $unit['service_charge'],
                'price' => $unit['price'],
                'startDate' => Carbon::parse(formatDate($startDate, 'd/m/Y', 'Y-m-d')),
                'dueDate' => Carbon::parse(formatDate($dueDate, 'd/m/Y', 'Y-m-d')),
                'user_id' => getOwnerUserID(),
                'tenant_id' => $tenants_ids,
            ]);

                if($asc){
                    self::addTenantToServiceCharge($tenantIds,$asc->id, $unit['service_charge'],$unit['price'],$startDate,$dueDate);
                 }
        }
    }

    public static function addTenantToServiceCharge($tenantIds,$sc_id,$service_charge_ids,$bal,$startDate,$dueDate){
        foreach ($tenantIds as $key => $id) {
            TenantServiceCharge::create([
                'tenant_id' => $id,
                'asc_id' =>$sc_id,
                'service_chargeId' => $service_charge_ids,
                'user_id' =>getOwnerUserID(),
                'bal' => $bal,
                'startDate' => Carbon::parse(formatDate($startDate, 'd/m/Y', 'Y-m-d')),
                'dueDate' => Carbon::parse(formatDate($dueDate, 'd/m/Y', 'Y-m-d')),
            ]);
        }
    }




    public static function updateServiceCharge($data){

         $tenants_ids = implode(' ', Input::get('tenant_id'));
         $tenantIds=$data['tenant_id'];
      $updateASC =  AssetServiceCharge::where('id',$data['id'])
        ->update([
                'asset_id' => $data['asset_id'],
                'service_charge_id' => $data['service_charge_id'],
                'price' => $data['price'],
                'user_id' => getOwnerUserID(),
                'tenant_id' => $tenants_ids,
        ]);

        if($updateASC){
           //dd($data['id']);
           self::updateTenantAddedToServiceCharge($tenantIds,$data['id']);
        }
    }


 public static function updateTenantAddedToServiceCharge($tenantIds,$sc_id){
   // dd($tenantIds);
         $updatetsc =   TenantServiceCharge::where('asc_id',$sc_id)->first();

        foreach ($tenantIds as $key => $tenantId) {
         if($updatetsc){
            $updatetsc->update([
                'tenant_id' => $tenantId,
                 'asc_id' =>$sc_id,
            ]);
                // $updatetsc->tenant_id = $tenantId;
                
                // $updatetsc->asc_id = $sc_id;
                // $updatetsc->save();
         }
            
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