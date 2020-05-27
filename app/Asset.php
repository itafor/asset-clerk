<?php

namespace App;

use App\AssetPhoto;
use App\AssetServiceCharge;
use App\Jobs\ServiceChargeInvoiceJob;
use App\PropertyFeature;
use App\Tenant;
use App\TenantRent;
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
        'description', 'category_id', 'quantity_added','quantity_left','price','property_type',
        'address','agent_id','country', 'state', 'features',
        'quantity_occupied','number_of_flat','commission',
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
        'status',
        'plan_id',
        'slot_plan_id'
    ];

    public function Tenant(){
        return $this->hasMany(Tenant::class);
    }

    public function country(){
        return $this->belongsTo(Country::class,'country_id','id');
    }

    public function state(){
        return $this->belongsTo(State::class,'state_id','id');
    }

    public function city(){
        return $this->belongsTo(City::class,'city_id','id');
    }

    public function Landlord(){
        return $this->belongsTo(Landlord::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function propertyType()
    {
        return $this->belongsTo(PropertyType::class,'property_type','id');
    }

    public function photos()
    {
        return $this->hasMany(AssetPhoto::class);
    }

    public function getfeatures()
    {
        return $this->hasMany(PropertyFeature::class);
    }
    
    public function units()
    {
        return $this->hasMany(Unit::class);
    }
    
    public function serviceCharges()
    {
        return AssetServiceCharge::where('asset_id', $this->id)->get();
    }



    public static function createNew($data)
    {
        //dd($data);
        
        $getActivePlan =  activePlanId(getOwnerUserID());
        $landlord = isset($data['landlord']) ? $data['landlord'] : '';
        $asset = self::create([
            // 'commission' => $data['commission'],
            'description' => $data['description'],
            'landlord_id' => $landlord,
            //'price' => $data['asking_price'],
            //'number_of_flat' => $numberOfFlat,
            //'quantity_left' => $numberOfFlat,
            //'quantity_occupied' => 0,
            //'property_type' => $data['property_type'],
            'country_id' => $data['country'],
            'state_id' => $data['state'],
            'city_id' => $data['city'],
            // 'detailed_information' => $data['detailed_information'],
            'address' => $data['address'],
            // 'construction_year' => $data['construction_year'],
            // 'features' => isset($data['features']) ? implode(',',$data['features']) : null,
            'uuid' => generateUUID(),
            'user_id' => getOwnerUserID(),
            'plan_id' => $getActivePlan,
            'slot_plan_id' => $getActivePlan,

        ]); 

          self::createUnit($data,$asset);
        // self::addPhoto($data,$asset); 
        return $asset;
    }

    public static function updateAsset($data)
    {
         //dd($data);
        $landlord = isset($data['landlord']) ? $data['landlord'] : '';
        
        self::where('uuid', $data['uuid'])->update([
            // 'commission' => $data['commission'],
            'description' => $data['description'],
            // 'price' => $data['asking_price'],
            //'property_type' => $data['property_type'],
            'landlord_id' => $landlord,
            'country_id' => $data['country'],
            'state_id' => $data['state'],
            'city_id' => $data['city'],
            // 'detailed_information' => $data['detailed_information'],
            'address' => $data['address'],
            // 'construction_year' => $data['construction_year'],
            // 'features' => implode(',',$data['features'])
        ]); 

        $asset = self::where('uuid', $data['uuid'])->first();

        // if(isset($data['photos'])){
        //     self::addPhoto($data,$asset);
        // }
     self::updateUnits($data,$asset);
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
                'plan_id' => activePlanId(getOwnerUserID()),
                'number_of_room' => $unit['number_of_room'],
                'property_type_id' => $unit['property_type'],
                'standard_price' => $unit['standard_price'],
                'quantity' => $unit['quantity'],
                'quantity_left' => $unit['quantity'],
                'status' => 'vacant',
                'uuid' => generateUUID(),
            ]);
        }
    }
    

    public static function updateUnits($data,$asset)
    {

    //$unit->unit_uuid
        if(isset($data['unit'])){
        foreach($data['unit'] as $key => $unit){
            $u = Unit::where('uuid', $unit['unit_uuid'])->first();
            if($unit['quantity'] < $u->quantity){
            return false;
           }else{
            if($u){
                //$u->category_id = $unit['category'];
                $u->standard_price = $unit['standard_price'];
                $u->property_type_id = $unit['property_type'];
                $u->quantity = $unit['quantity'];
                $u->number_of_room = $unit['number_of_room'];
                //$u->apartment_type = $unit['apartment_type'];
                $u->quantity_left =  getQtyLeft($unit['quantity'],$unit['unit_uuid']);
                //$u->rent_commission = $unit['rent_commission'];
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
                    'apartment_type' => $unit['apartment_type'],
                    'rent_commission' => $unit['rent_commission'],
                    'uuid' => generateUUID(),
                ]);
            }
        }
        }
    }

    }

 
    
    public static function addServiceCharge($data,$asset)
    {
        
        // $tenantIds=$data['tenant_id'];
        $tenantRent_ids=$data['tenant_rent_id'];
        $startDate = $data['startDate'];
        $dueDate = $data['dueDate'];
        $services = $data['service'];

        $service_chargeIDs=$data['service'];
        //$tenants_ids = implode(' ', Input::get('tenant_id'));//convert array to string
                foreach($data['service'] as $unit){
        $asc =  AssetServiceCharge::create([
                'asset_id' => $asset->id,
                'service_charge_id' => $unit['service_charge'],
                'price' => $unit['price'],
                'balance' => $unit['price'],
                'payment_status' => 'Pending',
                'startDate' => Carbon::parse(formatDate($startDate, 'd/m/Y', 'Y-m-d')),
                'dueDate' => Carbon::parse(formatDate($dueDate, 'd/m/Y', 'Y-m-d')),
                'user_id' => getOwnerUserID(),
                'description' => $unit['description'] ?  $unit['description'] : null,
                //'tenant_id' => $tenants_ids,
            ]);

                if($asc){
                    self::addTenantToServiceCharge($tenantRent_ids,$asc->id, $unit['service_charge'],$unit['price'],$startDate,$dueDate);
                 }
        }
    }

    public static function addTenantToServiceCharge($tenantRent_ids,$sc_id,$service_charge_ids,$bal,$startDate,$dueDate){
        foreach ($tenantRent_ids as $key => $id) {
            $rental = TenantRent::where('id',$id)->first();
            $tenantid = $rental->tenant->id;
            TenantServiceCharge::create([
                'tenant_id' => $tenantid,
                'tenant_rent_id' => $id,
                'asc_id' =>$sc_id,
                'service_chargeId' => $service_charge_ids,
                'user_id' =>getOwnerUserID(),
                'bal' => $bal,
                'paymentStatus'=>'Pending',
                'startDate' => Carbon::parse(formatDate($startDate, 'd/m/Y', 'Y-m-d')),
                'dueDate' => Carbon::parse(formatDate($dueDate, 'd/m/Y', 'Y-m-d')),
            ]);
            $tenant = Tenant::where('id',$tenantid)->first();
            $serviceCharge = AssetServiceCharge::with('asset','serviceCharge')
            ->where('user_id',getOwnerUserID())
            ->where('id',$sc_id)->first();

            ServiceChargeInvoiceJob::dispatch($tenant,$serviceCharge,$rental)
                ->delay(now()->addSeconds(3));
        }
    }

    public static function updateServiceCharge($data){

         // $tenants_ids = implode(' ', Input::get('tenant_id'));
         $tenantIds=$data['tenant_id'];
      $updateASC =  AssetServiceCharge::where('id',$data['id'])
        ->update([
                'asset_id' => $data['asset_id'],
                'service_charge_id' => $data['service_charge_id'],
                'price' => $data['price'],
                'user_id' => getOwnerUserID(),
                // 'tenant_id' => $tenants_ids,
        ]);

        if($updateASC){
           self::updateTenantAddedToServiceCharge($tenantIds,$data['id']);
        }
    }


 public static function updateTenantAddedToServiceCharge($tenantIds,$sc_id){
         $updatetsc =   TenantServiceCharge::where('asc_id',$sc_id)->first();

        foreach ($tenantIds as $key => $tenantId) {
         if($updatetsc){
            $updatetsc->update([
                'tenant_id' => $tenantId,
                 'asc_id' =>$sc_id,
            ]);
                
         }
            
        }
    }

    public static function addPhoto($data,$asset)
    {
       
        if(isset($data['photos'])){
            foreach($data['photos'] as $photo){
            $path = uploadImage($photo['image_url']);
            if($path){
                AssetPhoto::create([
                    'asset_id' => $asset->id,
                    'image_url' => $path
                ]);
            }
        }
        }
    }

      public static function addFeatures($data,$asset)
    {
      //dd($data['features']);
        // if(isset($data['features']) && count($data['features']) !=0){
            foreach($data['features'] as $feature){
            
                PropertyFeature::create([
                    'asset_id' => $asset->id,
                    'feature' => $feature,
                    'user_id' => getOwnerUserID()
                ]);
           
        }
        // }
    }

}