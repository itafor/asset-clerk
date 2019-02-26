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
    return AssetTenant::count();
}

function getTenants()
{
    return Tenant::orderBy('lastname')->get();
}