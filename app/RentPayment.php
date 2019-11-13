<?php

namespace App;

use App\TenantRent;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RentPayment extends Model
{
     use SoftDeletes;

      protected $fillable = [
        'uuid','tenant_uuid', 'asset_uuid','unit_uuid','tenantRent_uuid',
        'proposed_amount','actual_amount',
        'amount_paid','balance','payment_mode_id',
        'user_id','payment_date','payment_description','startDate','due_date'
    ];

   public function unitt() 
    {
        return $this->belongsTo(Unit::class, 'unit_uuid', 'uuid');
    }

    public function asset() 
    {
        return $this->belongsTo(Asset::class, 'asset_uuid', 'uuid');
    }

    public function paymentMode()
    {
        return $this->belongsTo(PaymentMode::class);
    }

    public function get_tenant(){
      return $this->belongsTo(Tenant::class,'tenant_uuid','uuid');
    }

    public static function createNew($data){

    	$rentPayment = self::create([
    			'uuid' =>  generateUUID(),
    			'tenant_uuid' => $data['tenant_uuid'],
    			'asset_uuid' => $data['asset_uuid'],
    			'unit_uuid' => $data['unit_uuid'],
    			'tenantRent_uuid' => $data['tenantRent_uuid'],
    			'proposed_amount' => $data['proposed_amount'],
    			'actual_amount' => $data['actual_amount'],
    			'amount_paid' => $data['amount_paid'],
    			'balance'     => $data['balance'],
    			'payment_mode_id' => $data['payment_mode_id'],
    			'user_id' => getOwnerUserID(),
    			'payment_date' => Carbon::parse(formatDate($data['payment_date'], 'd/m/Y', 'Y-m-d')),
    			'payment_description' => $data['payment_description'],
    			'startDate' => $data['startDate'],
    			'due_date' => $data['due_date'],
    	]);


    	if($rentPayment){
    		self::updateRentDebtorBalance($data,$rentPayment);
    		self::updateTenantRentBalance($data,$rentPayment);
    	}

    	return $rentPayment;
    }

      public static function updateRentDebtorBalance($data, $rentPayment){
      		$getRentDebtor = RentDebtor::where('tenantRent_uuid',$rentPayment->tenantRent_uuid)
                ->where('tenant_uuid',$rentPayment->tenant_uuid)
      					->where('user_id',getOwnerUserID())
      					->first();

      		if($getRentDebtor){
      			$getRentDebtor->balance = $rentPayment->balance;
      			$getRentDebtor->save();

            if($getRentDebtor->balance == 0){
                $getRentDebtor->delete();
            }
      		}

      		 
      }

      public static function updateTenantRentBalance($data, $rentPayment){
       		$getTenantRent = TenantRent::where('uuid', $rentPayment->tenantRent_uuid)
       						->where('user_id',getOwnerUserID())->first();
       		if($getTenantRent){
            $getTenantRent->balance = $rentPayment->balance;
      			$getTenantRent->status = $rentPayment->balance == 0 ? 'Paid' : 'Partly paid';
      			$getTenantRent->save();
      		}	
       }

}
