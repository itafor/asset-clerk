<?php

use App\Country;
use App\State;
use App\City;
use App\Category;
use App\Landlord;
use App\Asset;
use App\Tenant;
use App\AssetTenant;
use App\BuildingSection;
use App\AssetFeature;
use App\BuildingAge;
use App\TenantRent;
use App\ServiceCharge;
use App\Staff;
use App\RentDue;
use Illuminate\Support\Str;
use Cloudder;
use Carbon\Carbon;

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
    return Category::all();
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
    return Asset::where('user_id', getOwnerUserID())->count();
}

function getTotalSlots()
{
    $total_slots = 0;
    $available_slots = 0;
    $assets = Asset::where('user_id', getOwnerUserID())->with('units')->get();
    foreach($assets as $asset){
        $total_slots += $asset->units->sum('quantity');
        $available_slots += $asset->units->sum('quantity_left');
    }
    return [
        'available_slots' => $available_slots,
        'total_slots' => $total_slots,
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

function getServiceCharge($type)
{
    return ServiceCharge::where('type', $type)->orderBy('name')->get();
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
    $user = auth()->id();
    $plan = \App\Subscription::where('user_id',$user)->first();
    $plan_details = \App\SubscriptionPlan::where('uuid', $plan->plan_id)->first();
    $result = [
      'plan' => $plan,
      'details' => $plan_details
    ];
    return $result;
}

function chekUserPlan($type = null){
    $user = auth()->id();
    $plan = \App\Subscription::where('user_id',$user)->first();
    $plan_details = \App\SubscriptionPlan::where('uuid', $plan->plan_id)->first();
    $no_properties = $plan_details->properties;
    $no_accounts = $plan_details->sub_accounts;
    $service_charge = $plan_details->service_charge;
    switch ($type){
        case 'property':
            $customer_properties = Asset::where('user_id',$user)->count();
            if ($customer_properties >= $no_properties){
                return back()->with('error','You cannot manage more than '.$no_properties.' on this plan.Please upgrade!');
            }
            break;
        case 'accounts':
            $customer_accts = \Illuminate\Support\Facades\DB::table('staffs')->where('owner_id', $user)->count();
            if ($customer_accts >= $no_accounts){
                return back()->with('error','You cannot add more than '.$no_properties.' on this plan.Please upgrade!');
            }
            break;
        default:
            break;
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

function getSubscriptionByUUid($id){
    return \App\SubscriptionPlan::where('uuid', $id)->first();
}