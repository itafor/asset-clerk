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
    return Landlord::orderBy('lastname')->get();
}

function getTotalAssets()
{
    return Asset::count();
}

function getTotalTenants()
{
    return Tenant::count();
}

function getTotalLandlords()
{
    return Landlord::count();
}

function getTotalRentals()
{
    return TenantRent::count();
}

function getTenants()
{
    return Tenant::orderBy('lastname')->get();
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
    return Asset::where('category_id', $category)->get();
}