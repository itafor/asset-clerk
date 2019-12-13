<?php

use App\Asset;
use App\AssetFeature;
use App\AssetServiceCharge;
use App\BuildingAge;
use App\BuildingSection;
use App\Category;
use App\City;
use App\CompanyDetail;
use App\Country;
use App\Landlord;
use App\Occupation;
use App\PaymentMode;
use App\PaymentType;
use App\PropertyType;
use App\RentDue;
use App\ServiceCharge;
use App\Staff;
use App\State;
use App\SubscriptionPlan;
use App\Tenant;
use App\TenantRent;
use App\TenantServiceCharge;
use App\Unit;
use App\User;
use Carbon\Carbon;
use Illuminate\Support\Str;
use JD\Cloudder\Facades\Cloudder;


function generateUUID()
{
    return Str::uuid()->toString();
}

function getCountries()
{
    return Country::orderBy('name')->get();
}

function getStates($countryId)
{
    return State::where('country_id', $countryId)->orderBy('name')->get();
}

function getCities($stateId)
{
    return City::where('state_id', $stateId)->orderBy('name')->get();
}

function getCategories()
{
    return Category::orderBy('name')->get();
}

function getBuildingSections()
{
    return BuildingSection::all();
}

function getLandlords()
{
    return Landlord::where('user_id', getOwnerUserID())->orderBy('lastname')->get();
}

function getOwnerUserID()
{
    $user = auth()->user();
    if($user->sub_account == 0){
        return $user->id;
    }
    else if($user->sub_account == 1){ // Account is sub account
        $sub = Staff::where('staff_id', $user->id)->first();
        return $sub->owner_id;
    }
}

function getTotalAssets($user_id ='')
{
    //return Asset::where('user_id', getOwnerUserID())->count();
    $userId = $user_id !='' ? $user_id : getOwnerUserID();
    return Unit::where('user_id', $userId)
            ->where('plan_id', activePlanId($userId))
            ->sum('quantity');
}

function getSlots($user_id ='')
{
    $totalSlots = 0;
    $userId = $user_id !='' ? $user_id : getOwnerUserID();
    $user = User::find($userId);
    $sub = \App\Subscription::where('user_id', $user->id)->where('status', 'Active')->first();
    $plan = $sub ? \App\SubscriptionPlan::where('uuid', $sub->plan_id)->first() : null;
    $totalSlots = $plan == null ? 0 : $plan->properties;
    return [
        'availableSlots' => $totalSlots == 'Unlimited' ? 'Unlimited' : ($totalSlots - getTotalAssets($userId)),
        'totalSlots' => $totalSlots,
    ];
}

function activePlanId($userId){
    //$user = User::find(getOwnerUserID());
    $sub = \App\Subscription::where('user_id', $userId)->where('status', 'Active')->first();
    if($sub){
        return $sub->plan_id;
    }
}

function getTotalAgents()
{
    return Staff::where('owner_id', getOwnerUserID())->count();
}

function getAssets()
{
    return Asset::where('user_id', getOwnerUserID())->get();
}

function getTotalTenants()
{
    return Tenant::where('user_id', getOwnerUserID())->count();
}

function getTotalLandlords()
{
    return Landlord::where('user_id', getOwnerUserID())->count();
}

function getTotalRentals()
{
    return TenantRent::where('user_id', getOwnerUserID())->count();
}

function getTenants()
{
    return Tenant::where('user_id', getOwnerUserID())->orderBy('lastname')->get();
}

function getAssetFeatures()
{
    return AssetFeature::all();
}

function getBuildingAges()
{
    return BuildingAge::all();
}

function uploadImage($image)
{
    if(isset($image))
    {
        if($image->isValid()) 
        {
            $filename = $name = 'ASSET_'.$image->getClientOriginalName();
            $filename = str_replace(' ','_', $filename);
            $trans = array(
                ".png" => "", 
                ".PNG" => "",
                ".JPG" => "",
                ".jpg" => "",
                ".jpeg" => "",
                ".JPEG" => "",
                ".bmp" => "",
                ".pdf" => "",
            );
            $filename = strtr($filename,$trans);
            Cloudder::upload($image->getPathname(), $filename);
            $response = Cloudder::getResult();
            $path = $response['secure_url'];
            $image->move(public_path("uploads"), $image->getClientOriginalName());
        }
    }
    return $path;
}

function formatDate($date, $oldFormat, $newFormat)
{
    return Carbon::createFromFormat($oldFormat, $date)->format($newFormat);
}

function getAssetDescription($category)
{
    return Asset::where('user_id', getOwnerUserID())->where('category_id', $category)->get();
}

function getServiceCharge($type = null)
{
    if($type) {
        return ServiceCharge::where('type', $type)->orderBy('name')->get();
    } else {
        return ServiceCharge::orderBy('name')->get();
    }
}

function getServiceChargeType($serviceCharge)
{
    $sc = ServiceCharge::where('name',$serviceCharge)->first();
    if($sc){
        return $sc->type;
    }   
    else{   
        return '';
    }
}

function getPaymentServiceCharge($payment)
{
    if($payment->service_charge_id) {
        return "({$payment->serviceCharge->name})";
    } else {
        return '';
    }
}

function getNextRentPayment($rental)
{
    $rent = TenantRent::where('id', $rental->id)->latest()->first();
    return [
        'due_date' => formatDate($rent->due_date, 'Y-m-d', 'd M Y'),
        'startDate' => formatDate($rent->startDate, 'Y-m-d', 'd M Y'),
        'status' => ucwords($rent->status)
    ];
}

/**
 * param $past is true to get past due payments
 */
function getDuePayments($past = false)
{
    if($past){
        return TenantRent::where([
            ['user_id', getOwnerUserID()],
            ['status', 'pending']])
            ->whereRaw("DATE(due_date) < CURDATE()")
            ->sum('amount');
    }
    else{
        return TenantRent::where([
            ['user_id', getOwnerUserID()],
            ['status', 'pending']])
            ->whereRaw("DATE(due_date) = CURDATE()")
            ->sum('amount');
    }
}

/**
 * param $past is true to get past due payments
 */
function getDebtors($past = false)
{
    if($past){
        return TenantRent::where([
            ['user_id', getOwnerUserID()],
            ['status', 'pending'],
            ['status', 'Partly paid']])
            ->whereRaw("DATE(due_date) < CURDATE()")
            ->count();
    }
    else{
        return TenantRent::where([
            ['user_id', getOwnerUserID()],
            ['status', 'pending']])
            ->whereRaw("DATE(due_date) = CURDATE()")
            ->count();
    }
}

function getUserPlan($user_id =''){
    $user = $user_id == '' ? getOwnerUserID() : $user_id;
    $plan = \App\Subscription::where('user_id',$user)->where('status','Active')->first();
    if (!is_null($plan)){
        $plan_details = \App\SubscriptionPlan::where('uuid', $plan->plan_id)->first();
        $result = [
            'plan' => $plan,
            'details' => $plan_details
        ];
        return $result;
    }else{
        return null;
    }

}

function chekUserPlan($type = null){
    $user = getOwnerUserID();
    $plan = \App\Subscription::where('user_id',$user)->first();
    if($plan){
        $plan_details = \App\SubscriptionPlan::where('uuid', $plan->plan_id)->first();
        $no_properties = $plan_details->properties;
        $no_accounts = $plan_details->sub_accounts;
        $service_charge = $plan_details->service_charge;
        switch ($type){
            case 'property':
                $customer_properties = Asset::where('user_id',$user)->count();
                if($no_properties != 'Unlimited') {
                    if ($customer_properties >= $no_properties){
                        return back()->with('error','You cannot manage more than '.$no_properties.' on this plan. Please upgrade!');
                    }
                }
                break;
            case 'accounts':
                $customer_accts = \Illuminate\Support\Facades\DB::table('staffs')->where('owner_id', $user)->count();
                if ($customer_accts >= $no_accounts){
                    return back()->with('error','You cannot add more than '.$no_accounts.' sub accounts on this plan. Please upgrade!');
                }
                break;
            default:
                break;
        }
    }
    else{
        return back()->with('error', 'You currently don\'t have any active plan');
    }
}

function fixKobo($amount)
{
    $naira = explode('.', round($amount,2));
    if(isset($naira[1])){ // amount has decimal value
        if(strlen($naira[1]) > 1){
            return $naira[0].$naira[1]; // amount has more than one decimal point so no need to add zero
        }
        else if(strlen($naira[1]) == 1){
            return $naira[0].$naira[1].'0'; // amount has only one decimal point to add just one zero
        }
    }
    else{
        return $naira[0].'00';
    }
}

function getSubscriptionByUUid($id)
{
    return \App\SubscriptionPlan::where('uuid', $id)->first();
}

function getPropertyTypes()
{
    return PropertyType::all();
}

function getPaymentTypes()
{
    return PaymentType::all();
}

function getPaymentModes()
{
    return PaymentMode::all();
}

function getOccupations()
{
    return Occupation::orderBy('name')->get();
}

function removeTenantFromServiceCharge($tenant_id,$sc_id){
  $asset = AssetServiceCharge::find($sc_id);

//           $tenants = $asset->tenant_id;
//           $tenants_ids=explode(' ',$tenants);

// //search for $tenant_id in $tenants_ids array
//           $key = array_search($tenant_id, $tenants_ids);
// //if the id is found, remove it
//           \array_splice($tenants_ids, $key, 1);

//            $tenantIds=implode(' ',$tenants_ids);

          $deleteTenantfromSC = TenantServiceCharge::where('asc_id',$sc_id)
          ->where('tenant_id',$tenant_id)->first();

           if($deleteTenantfromSC->delete()){
        return true;
           }
         return false;
}

function removeServiceChargeWithoutTenant($ascId){
   // dd($ascId);
    $getTenantServiceCharges=TenantServiceCharge::all();
    foreach ($getTenantServiceCharges as $key => $tsc) {
       if($tsc->asc_id != $ascId){
          $checkASC =  AssetServiceCharge::where('id',$ascId)->first();
          if($checkASC){
            $checkASC->delete();
          }
       }else{
        return false;
       }
    }

}

function check_if_user_upload_comany_detail(){
        $details = CompanyDetail::where('user_id',auth()->user()->id)->first();
       if($details){
        return true;
       }else{
        return false;
       }
    }

    function comany_detail($userId){
        $details = CompanyDetail::where('user_id',$userId)->first();
       if($details){
        return $details;
       }else{
        return false;
       }
    }

    function getUsers(){
        $users=User::where('email','!=','admin@assetclerk.com')->get();
        if($users){
             return $users;
       }else{
        return false;
       }
    }

    function getAllPlans(){
        $plans = SubscriptionPlan::all();
        if($plans){
             return $plans;
       }else{
        return false;
       }
    }