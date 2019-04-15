<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Asset;
use App\ServiceCharge;
use DB;

class UtilsController extends Controller
{
    public function fetchState($country)
    {
        $states = getStates($country);
        return response()->json($states);
    }

    public function fetchCity($state)
    {
        $cities = getCities($state);
        return response()->json($cities);
    }

    public function fetchAssets($category)
    {
        $assets = Asset::where('category_id', $category)
        ->where('quantity_left', '!=', 0)
        ->select('uuid','description','price')->get();
        return response()->json($assets);
    }
    
    public function fetchServiceCharge($type)
    {
        $sc = ServiceCharge::where('type', $type)->orderBy('name')->get();
        return response()->json($sc);
    }

    public function searchUsers(Request $request)
    {
        $data = [];
        if ($request->has('q')) {
            $search = $request->q;
            $data = DB::table("users")
                ->select("id", "firstname", "lastname")
                ->where('email', 'LIKE', "%$search%")
                ->orWhere('firstname', 'LIKE', "%$search%")
                ->orWhere('lastname', 'LIKE', "%$search%")
                ->get();
            $data1 = DB::table("tenants")
                ->select("id", "firstname", "lastname")
                ->where('email', 'LIKE', "%$search%")
                ->orWhere('firstname', 'LIKE', "%$search%")
                ->orWhere('lastname', 'LIKE', "%$search%")
                ->get();
            $data = array_merge($data->all(),$data1->all());
        }
        return response()->json($data);
    }
}
