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