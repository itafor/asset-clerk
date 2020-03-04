<?php

namespace App\Http\Controllers;

use App\Landlord;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Validator;

class LandlordController extends Controller
{
    public function index()
    {
        $landlords = Landlord::where('user_id',getOwnerUserID())
        ->orderBy('firstname')->get();
        
        return view('new.admin.landlord.index', compact('landlords'));
    }

    public function create()
    {
        return view('new.admin.landlord.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            // 'designation' => 'required',
            // 'gender' => 'required',
            'firstname' => 'required',
            'lastname' => 'required',
            // 'date_of_birth' => 'required|date_format:"d/m/Y"',
            // 'occupation' => 'required',
            // 'country' => 'required',
            // 'state' => 'required',
            // 'city' => 'required',
            // 'address' => 'required',
            'email' => 'required|email',
            'contact_number' => 'required',
            // 'passport' => 'required|image'
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)
                        ->withInput()->with('error', 'Please fill in a required fields');
        }

        Landlord::createNew($request->all());

        return redirect()->route('landlord.index')->with('success', 'Landlord added successfully');
    }

    public function delete($uuid)
    {
        $landlord = Landlord::where('uuid', $uuid)->first();

        if(count($landlord->asset) > 0){
            return back()->with('error', 'Whoops! Cannot delete a landlord with already assigned asset(s)');
        }

        if($landlord){
            $landlord->delete();
            return back()->with('success', 'Landlord deleted successfully');
        }
        else{
            return back()->with('error', 'Whoops! Could not find landlord');
        }
    }

    public function edit($uuid)
    {
        $landlord = Landlord::where('uuid', $uuid)->first();
        if($landlord){
            return view('new.admin.landlord.edit', compact('landlord'));
        }
        else{
            return back()->with('error', 'Whoops! Could not find landlord');
        }
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            // 'designation' => 'required',
            // 'gender' => 'required',
            'firstname' => 'required',
            'lastname' => 'required',
            // 'date_of_birth' => 'required|date_format:"d/m/Y"',
            // 'occupation' => 'required',
            // 'country' => 'required',
            // 'state' => 'required',
            // 'city' => 'required',
            // 'address' => 'required',
            'email' => 'required|email',
            'contact_number' => 'required',
            // 'passport' => 'image',
            'uuid' => 'required'
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)
                        ->withInput()->with('error', 'Please fill in a required fields');
        }

        Landlord::updateLandlord($request->all());
        return redirect()->route('landlord.index')->with('success', 'Landlord updated successfully');
    }

    public function searchLandlord(Request $request){
     if($request->get('query2') && $request->query2 !='')
     {
      $query2 = $request->get('query2');
      $users = Landlord::where('firstname','like',"%{$query2}%")
      ->orwhere('lastname','like',"%{$query2}%")
      ->where('user_id', getOwnerUserID())
    ->get();
    if(count($users) > 1){
    $output = '<ul class="dropdown-menu" 
    style="display: block; 
    position: absolute; z-index: 100; width:300px; padding-left:20px; margin-left:40px; margin-top: -160px;">';

$output.='<li style="margin-left:230px; font-size:20px; color:red; cursor: pointer;">x</li>';
    foreach ($users as $row) {
       if($row->user_id == getOwnerUserID()){
$output.='<li id="landlordId" data-value="'.$row->id.'" style="cursor: pointer;">'.$row->firstname.' '.$row->lastname.'</li>';
 }
    }
   $output .='</ul>';
   echo $output;
}else{
    echo 'No matching records found';
}
    }

   }

public function fetchLandlord($id)
    {
        $landlord = Landlord::where('id',$id)->first();
        if($landlord){
            return response()->json($landlord);
        }
        else{
            return [];
        }
    }

}
