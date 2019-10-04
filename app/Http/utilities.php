<?php

use App\Country;
use App\State;
use App\City;
use App\Category;
use App\Landlord;
use App\Asset;
use App\Tenant;
use App\BuildingSection;
use App\AssetFeature;
use App\BuildingAge;
use App\TenantRent;
use App\ServiceCharge;
use App\Staff;
use App\RentDue;
use App\User;
use Illuminate\Support\Str;
use JD\Cloudder\Facades\Cloudder;
use Carbon\Carbon;
use App\PropertyType;
use App\PaymentType;
use App\PaymentMode;
use App\Occupation;
use App\Unit;

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

function getTotalAssets()
{
    //return Asset::where('user_id', getOwnerUserID())->count();
    return Unit::where('user_id',getOwnerUserID())->sum('quantity');
}

function getSlots()
{
    $totalSlots = 0;
    $user = User::find(getOwnerUserID());
    $sub = \App\Subscription::where('user_id', $user->id)->where('status', 'Active')->first();
    $plan = $sub ? \App\SubscriptionPlan::where('uuid', $sub->plan_id)->first() : null;
    $totalSlots = $plan == null ? 0 : $plan->properties;
    return [
        'availableSlots' => $totalSlots == 'Unlimited' ? 'Unlimited' : ($totalSlots - getTotalAssets()),
        'totalSlots' => $totalSlots,
    ];
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
            );
            $filename = strtr($filename,$trans);
            Cloudder::upload($image->getPathname(), $filename);
            $response = Cloudder::getResult();
            $path = $response['secure_url'];
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
    $sc = ServiceCharge::find($serviceCharge);
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
    $rent = RentDue::where('rent_id', $rental->id)->latest()->first();
    return [
        'due_date' => formatDate($rent->due_date, 'Y-m-d', 'd M Y'),
        'status' => ucwords($rent->status)
    ];
}

/**
 * param $past is true to get past due payments
 */
function getDuePayments($past = false)
{
    if($past){
        return RentDue::where([
            ['user_id', getOwnerUserID()],
            ['status', 'pending']])
            ->whereRaw("DATE(due_date) < CURDATE()")
            ->sum('amount');
    }
    else{
        return RentDue::where([
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
        return RentDue::where([
            ['user_id', getOwnerUserID()],
            ['status', 'pending']])
            ->whereRaw("DATE(due_date) < CURDATE()")
            ->count();
    }
    else{
        return RentDue::where([
            ['user_id', getOwnerUserID()],
            ['status', 'pending']])
            ->whereRaw("DATE(due_date) = CURDATE()")
            ->count();
    }
}

function getUserPlan(){
    $user = getOwnerUserID();
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