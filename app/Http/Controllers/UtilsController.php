<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Asset;
use App\ServiceCharge;
use App\Unit;
use App\User;
use App\Tenant;
use DB;
use Mail;
use App\Mail\EmailVerification;

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
        ->where('user_id', getOwnerUserID())
        ->select('uuid','description','price')->get();
        return response()->json($assets);
    }
    
    public function fetchServiceCharge($type)
    {
        $sc = ServiceCharge::where('type', $type)->orderBy('name')->get();
        return response()->json($sc);
    }

    public function fetchServiceChargeByProperty($property)
    {
        $asset = Asset::where('uuid', $property)->first();
        if($asset){
            $sc = ServiceCharge::join('asset_service_charges as ac', 'ac.service_charge_id', '=', 'service_charges.id')
            ->where('ac.asset_id', $asset->id)->orderBy('name')->select('service_charges.*', 'ac.price')->get();
            return response()->json($sc);
        } else{
            return [];
        }
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

    public function fetchUnits($property)
    {
        $property = Asset::where('uuid', $property)->first();
        if($property){
            $units = Unit::where('asset_id', $property->id)
            ->join('categories as c', 'c.id', '=', 'units.category_id')
            ->select('units.*', 'c.name')
            ->where('units.quantity_left', '>', 0)
            ->get();
            return response()->json($units);
        }
        else{
            return [];
        }
    }

    public function resendVerification()
    {
        try{
            $user = auth()->user();
            if($user->verified == 'yes'){
                return back()->with('info', 'Your email address is already verified');
            }
            if($user->verify_token == ''){
                $user->verify_token = str_random(60);
                $user->save();
            }
            Mail::to($user->email)->send(new EmailVerification($user));
            return back()->with('success', 'Verification email sent successfully');
        }
        catch(\Exception $e){
            return back()->with('error', 'Oops! An error occured. Please try again');
        }
    }

    public function verify($email, $token)
    {
        $user = User::where('email', $email)
        ->where('verify_token', $token)
        ->first();

        if($user){
            $user->verify_token = '';
            $user->verified = 'yes';
            $user->save();
            return redirect('/')->with('success', 'Email verification successful');
        }
        else{
            abort(404, 'Invalid link');
        }
    }

    public function fetchRentedUnits($property)
    {
        $property = Asset::where('uuid', $property)->where('user_id', getOwnerUserID())->first();
        if($property){
            $units = Unit::where('units.asset_id', $property->id)
            ->join('categories as c', 'c.id', '=', 'units.category_id')
            ->join('tenant_rents as tr', 'tr.unit_uuid', '=', 'units.uuid')
            ->join('tenants as t', 't.uuid', '=', 'tr.tenant_uuid')
            ->selectRaw('units.*, c.name, CONCAT(t.designation, " ", t.firstname, " ", t.lastname) as tenant')
            ->where('units.quantity_left', '>', 0)
            ->whereNull('tr.deleted_at')
            ->whereRaw('tr.due_date > CURDATE()')
            ->get();
            return response()->json($units);
        }
        else{
            return [];
        }
    }
    
    public function fetchTenantAsset($tenant)
    {
        $tenant = Tenant::find($tenant);
        if($tenant){
            $units = Unit::join('categories as c', 'c.id', '=', 'units.category_id')
            ->join('assets as a', 'a.id', '=', 'units.asset_id')
            ->join('tenant_rents as tr', 'tr.unit_uuid', '=', 'units.uuid')
            ->join('tenants as t', 't.uuid', '=', 'tr.tenant_uuid')
            ->selectRaw('c.name as unit, a.description as asset, a.uuid as uuid')
            ->where('tr.tenant_uuid', $tenant->uuid)
            ->whereNull('tr.deleted_at')
            ->whereRaw('tr.due_date > CURDATE()')
            ->get();
            return response()->json($units);
        }
        else{
            return [];
        }
    }

    public function loadDB()
    {
        $statesNew = DB::table('states_new')->get();
        
        foreach($statesNew as $s) {
            $lgas = DB::table('locals')->where('state_id', $s->id)->get();
            
            $state = DB::table('states')->where('name', $s->name)->first();

            foreach($lgas as $lga) {
                $city = DB::table('cities')->where('name', $lga->local_name)->first();
                if(! $city) {
                    DB::table('cities')->insert([
                        'name' => $lga->local_name,
                        'state_id' => $state->id
                    ]);
                }
            }

        }

        return 'Done';
    }
}
