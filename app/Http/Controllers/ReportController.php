<?php

namespace App\Http\Controllers;

use App\Asset;
use App\TenantRent;
use App\Unit;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function assets()
    {
        return view('new.admin.reports.assets');
    }

    public function rentalPaymentStatus($unit_uuid){
        $rentals = TenantRent::where('user_id', getOwnerUserID())
                    ->where('unit_uuid',$unit_uuid)
        ->orderBy('id', 'desc')->get();
        return view('new.admin.reports.rental_payment_status', compact('rentals'));
    }

public function occupancy($asset_id,$occupancy = ''){

if($occupancy == 'All'){
        $all = Unit::where('asset_id',$asset_id)
        ->where('user_id',getOwnerUserID())
        ->get();
        
        $output = '
    
     ';  
     foreach($all as $allasset)
     {
      $output .= '
   
      <tr>
       <td>'.$allasset->asset->description.'</td>
       <td>'.$allasset->asset->address.'</td>
       <td>'.$allasset->asset->landlord->designation. ' '. $allasset->asset->landlord->firstname. ' '. $allasset->asset->landlord->lastname. '</td>
       <td>'.'All('.$allasset->quantity_left.')'.'</td>
       <td>'.'<a href="/report/get-payment-status/'.$allasset->uuid.'" target="_blank">'.'View'.'</a>'.'</td>
       <td>'.$allasset->propertyType->name.'</td>
       <td>'.$allasset->category->name.' Bedroom'.'</td>

       <td>'.$allasset->quantity.'</td>
       <td>'.$allasset->quantity_left.'</td>
      </tr>
      ';
     }
  
     return $output;
}elseif($occupancy == 'Occupied'){
           $all = Unit::where('asset_id',$asset_id)
        ->where('user_id',getOwnerUserID())
        ->where('quantity_left','0')
        ->get();
        
        $output = '
    
     ';  
     foreach($all as $allasset)
     {
      $output .= '
   
      <tr>
       <td>'.$allasset->asset->description.'</td>
       <td>'.$allasset->asset->address.'</td>
       <td>'.$allasset->asset->landlord->designation. ' '. $allasset->asset->landlord->firstname. ' '. $allasset->asset->landlord->lastname. '</td>
       <td>'.'Occupied('.$allasset->quantity_left.')'.'</td>
       <td>'.'<a href="/report/get-payment-status/'.$allasset->uuid.'" target="_blank">'.'View'.'</a>'.'</td>
       <td>'.$allasset->propertyType->name.'</td>
       <td>'.$allasset->category->name.' Bedroom'.'</td>

       <td>'.$allasset->quantity.'</td>
       <td>'.$allasset->quantity_left.'</td>
      </tr>
      ';
     }
  
     return $output;

}elseif($occupancy == 'Vacant'){
           $all = Unit::where('asset_id',$asset_id)
        ->where('user_id',getOwnerUserID())
        ->where('quantity_left','>','0')
        ->get();
        
        $output = '
    
     ';  
     foreach($all as $allasset)
     {
      $output .= '
   
      <tr>
       <td>'.$allasset->asset->description.'</td>
       <td>'.$allasset->asset->address.'</td>
       <td>'.$allasset->asset->landlord->designation. ' '. $allasset->asset->landlord->firstname. ' '. $allasset->asset->landlord->lastname. '</td>
       <td>'.'Vacant('.$allasset->quantity_left.')'.'</td>
       <td>'.'<a href="/report/get-payment-status/'.$allasset->uuid.'" target="_blank">'.'View'.'</a>'.'</td>
       <td>'.$allasset->propertyType->name.'</td>
       <td>'.$allasset->category->name.' Bedroom'.'</td>

       <td>'.$allasset->quantity.'</td>
       <td>'.$allasset->quantity_left.'</td>
      </tr>
      ';
     }
  
     return $output;

        }

}


    public function asset_payment($asset_id,$payment_status = '')
    {
       if($payment_status == 'All'){
    $asset = Asset::where('id',$asset_id)->first();
    
    $all = TenantRent::where('tenant_rents.asset_uuid',$asset->uuid)
        ->where('user_id',getOwnerUserID())
        ->get();
       // return  $all;
        $output = '
    
     ';  
     foreach($all as $allasset)
     {
      $output .= '
   
      <tr>
       <td>'.$allasset->asset->description.'</td>
       <td>'.$allasset->asset->address.'</td>
       <td>'.$allasset->asset->Landlord->designation. ' '. $allasset->asset->Landlord->firstname. ' '. $allasset->asset->Landlord->lastname. '</td>
       <td class="text-secondary">'.$allasset->status.'</a>'.'</td>
      
       <td>'.$allasset->unit->propertyType->name.'</td>

       <td>'.$allasset->unit->category->name.' Bedroom'.'</td>

      </tr>
      ';
     }
  
     return $output;

}elseif($payment_status == 'Paid'){
    $asset = Asset::where('id',$asset_id)->first();
    
    $all = TenantRent::where('tenant_rents.asset_uuid',$asset->uuid)
        ->where('status', 'Paid')
        ->where('user_id',getOwnerUserID())
        ->get();
       // return  $all;
        $output = '
    
     ';  
     foreach($all as $allasset)
     {
      $output .= '
   
      <tr>
       <td>'.$allasset->asset->description.'</td>
       <td>'.$allasset->asset->address.'</td>
       <td>'.$allasset->asset->Landlord->designation. ' '. $allasset->asset->Landlord->firstname. ' '. $allasset->asset->Landlord->lastname. '</td>
       <td class="text-success">'.$allasset->status.'</a>'.'</td>
      
       <td>'.$allasset->unit->propertyType->name.'</td>

       <td>'.$allasset->unit->category->name.' Bedroom'.'</td>
       

       
      </tr>
      ';
     }
  
     return $output;

}elseif($payment_status == 'Partly'){
    $asset = Asset::where('id',$asset_id)->first();
    
    $all = TenantRent::where('tenant_rents.asset_uuid',$asset->uuid)
        ->where('status', 'Partly paid')
        ->where('user_id',getOwnerUserID())
        ->get();
       // return  $all;
        $output = '
    
     ';  
     foreach($all as $allasset)
     {
      $output .= '
   
      <tr>
       <td>'.$allasset->asset->description.'</td>
       <td>'.$allasset->asset->address.'</td>
       <td>'.$allasset->asset->Landlord->designation. ' '. $allasset->asset->Landlord->firstname. ' '. $allasset->asset->Landlord->lastname. '</td>
       <td class="text-warning">'.$allasset->status.'</a>'.'</td>
      
       <td>'.$allasset->unit->propertyType->name.'</td>

       <td>'.$allasset->unit->category->name.' Bedroom'.'</td>
       

       
      </tr>
      ';
     }
  
     return $output;

}elseif($payment_status == 'Unpaid'){
    $asset = Asset::where('id',$asset_id)->first();
    
    $all = TenantRent::where('tenant_rents.asset_uuid',$asset->uuid)
        ->where('status', 'Pending')
        ->where('user_id',getOwnerUserID())
        ->get();
       // return  $all;
        $output = '
    
     ';  
     foreach($all as $allasset)
     {
      $output .= '
   
      <tr>
       <td>'.$allasset->asset->description.'</td>
       <td>'.$allasset->asset->address.'</td>
       <td>'.$allasset->asset->Landlord->designation. ' '. $allasset->asset->Landlord->firstname. ' '. $allasset->asset->Landlord->lastname. '</td>
       <td class="text-danger">'.$allasset->status.'</a>'.'</td>
      
       <td>'.$allasset->unit->propertyType->name.'</td>

       <td>'.$allasset->unit->category->name.' Bedroom'.'</td>
       

       
      </tr>
      ';
     }
  
     return $output;

}


    }
    
    public function approvals()
    {
        return view('new.admin.reports.approvals');
    }
    
    public function maintenance()
    {
        return view('new.admin.reports.maintenance');
    }

    public function legal()
    {
        return view('new.admin.reports.legal');
    }

 }
