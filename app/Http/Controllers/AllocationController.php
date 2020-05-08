<?php

namespace App\Http\Controllers;

use App\Jobs\RentalCreatedEmailJob;
use App\TenantRent;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Validator;
use DateTime;

class AllocationController extends Controller
{
     public function index()
    {
        $rentals = TenantRent::where('user_id', getOwnerUserID())
                ->where('startDate',null)
                ->where('due_date',null)
                ->where('amount',null)
        ->orderBy('id', 'desc')->get();

        return view('new.admin.allocation.index', compact('rentals'));
    }

     public function create()
    {
        return view('new.admin.allocation.create');
    }

    public function store(Request $request)
    {
    

        $validator = Validator::make($request->all(), [
            'tenant' => 'required',
            'property' => 'required',
            'main_unit' => 'required',
            'sub_unit' => 'required',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)
                        ->withInput()->with('error', 'Please fill in a required fields');
        }

    $data=$request->all();

    $getTenantRents = TenantRent::where('tenant_rents.asset_uuid', $data['property'])
                     ->where('flat_number',$data['sub_unit'])
                     ->where('unit_uuid',$data['main_unit'])
                    ->get();
                            
    if(count($getTenantRents) >=1){
                 return back()->withInput()->with('error','The selected unit has already been assigned');
            }



        DB::beginTransaction();
        try {
            $rental = self::createNew($request->all());

            // RentalCreatedEmailJob::dispatch($rental)
            //     ->delay(now()->addSeconds(3));

            DB::commit();
        } catch (Exception $e) {
            DB::rollback();
            return back()->with('error', 'Whoops! An error occured. Please try again.');
        }

        return redirect()->route('allocation.index')->with('success', 'Tenant successfully allocated to a property');
    }

    public static function createNew($data)
    {
        
        
        $rental = TenantRent::create([
            'tenant_uuid' => $data['tenant'],
            'asset_uuid' => $data['property'],
            'unit_uuid' => $data['main_unit'],
            'flat_number' => $data['sub_unit'],
            'uuid' => generateUUID(),
            'user_id' => $data['user_id'] ? $data['user_id'] : getOwnerUserID(),
        ]);
         
        TenantRent::reduceUnitQuantityByOne($data, $rental);
        return $rental;
    }

}
