<?php

namespace App\Http\Controllers;

use App\Asset;
use App\TenantRent;
use App\Unit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Validator;

class ReportController extends Controller
{

  public function assetReport(Request $request) {
      $occupancy = '';
      $selected_asset = '';
      $asset_name = '';
      $payment = '';
      $apartment_type = '';
  return view('new.admin.reports.asset_report',compact('occupancy','selected_asset','payment','apartment_type','asset_name'));
  }
  public function getAsset($id){
    $fetch_asset = Asset::where('id',$id)
                    ->where('user_id',getOwnerUserID())->first();
                    if($fetch_asset){
                      return $fetch_asset->description;
                    }
  }
  public function getAssetReport(Request $request) {
    
    $data = $request->all();
        $validator = Validator::make($data, [
            'asset_id' => 'required',
            'occupancy' => 'required',
            'payment' => 'required',
            'apartment_type' => 'required',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)
                        ->withInput()->with('error', 'Please fill in a required fields');
        }


    if($data['asset_id'] !=='' && $data['occupancy'] =='Vacant' && $data['payment'] =='Paid') {
        return redirect()->route('report.assetreport')->with('error', ' paid vacant asset not found');
    }elseif($data['asset_id'] !=='' && $data['occupancy'] =='Vacant' &&  $data['payment'] =='Partly') {
        return redirect()->route('report.assetreport')->with('error', 'Partly paid vacant asset not found ');
    }elseif($data['asset_id'] !=='' && $data['occupancy'] =='Vacant' &&  $data['payment'] =='Unpaid') {
        return redirect()->route('report.assetreport')->with('error','Unpaid vacant asset not found ');
    }
  
    if($data['asset_id'] !=='' && $data['occupancy'] =='All' && $data['payment'] =='All' && $data['apartment_type'] == 'Commercial')
    {
      $occupancy = 'All';
      $selected_asset = $data['asset_id'];
      $asset_name = $this->getAsset($selected_asset);
      $payment = $data['payment'];
      $apartment_type = $data['apartment_type'];
    $asset_reports =  Unit::join('tenant_rents as tr','tr.unit_uuid','=','units.uuid')
        ->join('tenants as tn','tn.uuid','=','tr.tenant_uuid')
        ->join('assets','assets.id','=','units.asset_id')
        ->join('landlords as ll','ll.id','=','assets.landlord_id')
        ->join('property_types as pt','pt.id','=','units.property_type_id')
        ->where('units.asset_id',$data['asset_id'])
        ->where('units.user_id',getOwnerUserID())
        ->where('units.apartment_type','Commercial')
        ->select('tr.amount as amt','tr.balance as bal','tr.status as payment_status','units.asset_id as assetId','units.quantity as qty','units.quantity_left as qty_left','units.apartment_type as apartmentType','assets.description as assetName','assets.address as locatn','pt.name as proptype', DB::raw('CONCAT(tn.designation, " ", tn.firstname, " ", tn.lastname) as tenantDetail'),DB::raw('CONCAT(ll.designation, " ", ll.firstname, " ", ll.lastname) as landlordDetail'))
        ->get();
  return view('new.admin.reports.asset_report',compact('asset_reports','occupancy','selected_asset','payment','apartment_type','asset_name'));
}elseif($data['asset_id'] !=='' && $data['occupancy'] =='Occupied' && $data['payment'] =='All' && $data['apartment_type'] == 'Commercial')
    {
      $occupancy = 'Occupied';
      $selected_asset = $data['asset_id'];
      $asset_name = $this->getAsset($selected_asset);
      $payment = $data['payment'];
      $apartment_type = $data['apartment_type'];
    $asset_reports =  Unit::join('tenant_rents as tr','tr.unit_uuid','=','units.uuid')
        ->join('tenants as tn','tn.uuid','=','tr.tenant_uuid')
        ->join('assets','assets.id','=','units.asset_id')
        ->join('landlords as ll','ll.id','=','assets.landlord_id')
        ->join('property_types as pt','pt.id','=','units.property_type_id')
        ->where('units.asset_id',$data['asset_id'])
        ->where('units.user_id',getOwnerUserID())
        ->where('units.quantity_left','<=','0')
        ->where('units.apartment_type','Commercial')
        ->select('tr.amount as amt','tr.balance as bal','tr.status as payment_status','units.asset_id as assetId','units.quantity as qty','units.quantity_left as qty_left','units.apartment_type as apartmentType','assets.description as assetName','assets.address as locatn','pt.name as proptype', DB::raw('CONCAT(tn.designation, " ", tn.firstname, " ", tn.lastname) as tenantDetail'),DB::raw('CONCAT(ll.designation, " ", ll.firstname, " ", ll.lastname) as landlordDetail'))
        ->get();
  return view('new.admin.reports.asset_report',compact('asset_reports','occupancy','selected_asset','payment','apartment_type','asset_name'));
}elseif($data['asset_id'] !=='' && $data['occupancy'] =='Vacant' && $data['payment'] =='All' && $data['apartment_type'] == 'Commercial')
    {
      $occupancy = 'Vacant';
      $selected_asset = $data['asset_id'];
      $asset_name = $this->getAsset($selected_asset);
      $payment = $data['payment'];
      $apartment_type = $data['apartment_type'];
    $asset_reports =  Unit::join('tenant_rents as tr','tr.unit_uuid','=','units.uuid')
        ->join('tenants as tn','tn.uuid','=','tr.tenant_uuid')
        ->join('assets','assets.id','=','units.asset_id')
        ->join('landlords as ll','ll.id','=','assets.landlord_id')
        ->join('property_types as pt','pt.id','=','units.property_type_id')
        ->where('units.asset_id',$data['asset_id'])
        ->where('units.user_id',getOwnerUserID())
        ->where('units.quantity_left','>=','1')
        ->where('units.apartment_type','Commercial')
        ->select('tr.amount as amt','tr.balance as bal','tr.status as payment_status','units.asset_id as assetId','units.quantity as qty','units.quantity_left as qty_left','units.apartment_type as apartmentType','assets.description as assetName','assets.address as locatn','pt.name as proptype', DB::raw('CONCAT(tn.designation, " ", tn.firstname, " ", tn.lastname) as tenantDetail'),DB::raw('CONCAT(ll.designation, " ", ll.firstname, " ", ll.lastname) as landlordDetail'))
        ->get();
  return view('new.admin.reports.asset_report',compact('asset_reports','occupancy','selected_asset','payment','apartment_type','asset_name'));
}else    if($data['asset_id'] !=='' && $data['occupancy'] =='All' && $data['payment'] =='All' && $data['apartment_type'] == 'Residential')
    {
      $occupancy = 'All';
      $selected_asset = $data['asset_id'];
      $asset_name = $this->getAsset($selected_asset);
      $payment = $data['payment'];
      $apartment_type = $data['apartment_type'];
    $asset_reports =  Unit::join('tenant_rents as tr','tr.unit_uuid','=','units.uuid')
        ->join('tenants as tn','tn.uuid','=','tr.tenant_uuid')
        ->join('assets','assets.id','=','units.asset_id')
        ->join('landlords as ll','ll.id','=','assets.landlord_id')
        ->join('property_types as pt','pt.id','=','units.property_type_id')
        ->where('units.asset_id',$data['asset_id'])
        ->where('units.user_id',getOwnerUserID())
        ->where('units.apartment_type','Residential')
        ->select('tr.amount as amt','tr.balance as bal','tr.status as payment_status','units.asset_id as assetId','units.quantity as qty','units.quantity_left as qty_left','units.apartment_type as apartmentType','assets.description as assetName','assets.address as locatn','pt.name as proptype', DB::raw('CONCAT(tn.designation, " ", tn.firstname, " ", tn.lastname) as tenantDetail'),DB::raw('CONCAT(ll.designation, " ", ll.firstname, " ", ll.lastname) as landlordDetail'))
        ->get();
  return view('new.admin.reports.asset_report',compact('asset_reports','occupancy','selected_asset','payment','apartment_type','asset_name'));
}elseif($data['asset_id'] !=='' && $data['occupancy'] =='Occupied' && $data['payment'] =='All' && $data['apartment_type'] == 'Residential')
    {
      $occupancy = 'Occupied';
      $selected_asset = $data['asset_id'];
      $asset_name = $this->getAsset($selected_asset);
      $payment = $data['payment'];
      $apartment_type = $data['apartment_type'];
    $asset_reports =  Unit::join('tenant_rents as tr','tr.unit_uuid','=','units.uuid')
        ->join('tenants as tn','tn.uuid','=','tr.tenant_uuid')
        ->join('assets','assets.id','=','units.asset_id')
        ->join('landlords as ll','ll.id','=','assets.landlord_id')
        ->join('property_types as pt','pt.id','=','units.property_type_id')
        ->where('units.asset_id',$data['asset_id'])
        ->where('units.user_id',getOwnerUserID())
        ->where('units.quantity_left','<=','0')
        ->where('units.apartment_type','Residential')
        ->select('tr.amount as amt','tr.balance as bal','tr.status as payment_status','units.asset_id as assetId','units.quantity as qty','units.quantity_left as qty_left','units.apartment_type as apartmentType','assets.description as assetName','assets.address as locatn','pt.name as proptype', DB::raw('CONCAT(tn.designation, " ", tn.firstname, " ", tn.lastname) as tenantDetail'),DB::raw('CONCAT(ll.designation, " ", ll.firstname, " ", ll.lastname) as landlordDetail'))
        ->get();
  return view('new.admin.reports.asset_report',compact('asset_reports','occupancy','selected_asset','payment','apartment_type','asset_name'));
}elseif($data['asset_id'] !=='' && $data['occupancy'] =='Vacant' && $data['payment'] =='All' && $data['apartment_type'] == 'Residential')
    {
      $occupancy = 'Vacant';
      $selected_asset = $data['asset_id'];
      $asset_name = $this->getAsset($selected_asset);
      $payment = $data['payment'];
      $apartment_type = $data['apartment_type'];
    $asset_reports =  Unit::join('tenant_rents as tr','tr.unit_uuid','=','units.uuid')
        ->join('tenants as tn','tn.uuid','=','tr.tenant_uuid')
        ->join('assets','assets.id','=','units.asset_id')
        ->join('landlords as ll','ll.id','=','assets.landlord_id')
        ->join('property_types as pt','pt.id','=','units.property_type_id')
        ->where('units.asset_id',$data['asset_id'])
        ->where('units.user_id',getOwnerUserID())
        ->where('units.quantity_left','>','0')
        ->where('units.apartment_type','Residential')
        ->select('tr.amount as amt','tr.balance as bal','tr.status as payment_status','units.asset_id as assetId','units.quantity as qty','units.quantity_left as qty_left','units.apartment_type as apartmentType','assets.description as assetName','assets.address as locatn','pt.name as proptype', DB::raw('CONCAT(tn.designation, " ", tn.firstname, " ", tn.lastname) as tenantDetail'),DB::raw('CONCAT(ll.designation, " ", ll.firstname, " ", ll.lastname) as landlordDetail'))
        ->get();
  return view('new.admin.reports.asset_report',compact('asset_reports','occupancy','selected_asset','payment','apartment_type','asset_name'));
}elseif($data['asset_id'] !=='' && $data['occupancy'] =='All' && $data['payment'] =='Paid' && $data['apartment_type'] == 'Commercial')
    {
      $occupancy = 'All';
      $selected_asset = $data['asset_id'];
      $asset_name = $this->getAsset($selected_asset);
      $payment = $data['payment'];
      $apartment_type = $data['apartment_type'];
    $asset_reports =  Unit::join('tenant_rents as tr','tr.unit_uuid','=','units.uuid')
        ->join('tenants as tn','tn.uuid','=','tr.tenant_uuid')
        ->join('assets','assets.id','=','units.asset_id')
        ->join('landlords as ll','ll.id','=','assets.landlord_id')
        ->join('property_types as pt','pt.id','=','units.property_type_id')
        ->where('units.asset_id',$data['asset_id'])
        ->where('units.user_id',getOwnerUserID())
        ->where('units.apartment_type','Commercial')
        ->where('tr.status','Paid')
        ->select('tr.amount as amt','tr.balance as bal','tr.status as payment_status','units.asset_id as assetId','units.quantity as qty','units.quantity_left as qty_left','units.apartment_type as apartmentType','assets.description as assetName','assets.address as locatn','pt.name as proptype', DB::raw('CONCAT(tn.designation, " ", tn.firstname, " ", tn.lastname) as tenantDetail'),DB::raw('CONCAT(ll.designation, " ", ll.firstname, " ", ll.lastname) as landlordDetail'))
        ->get();
  return view('new.admin.reports.asset_report',compact('asset_reports','occupancy','selected_asset','payment','apartment_type','asset_name'));
}elseif($data['asset_id'] !=='' && $data['occupancy'] =='All' && $data['payment'] =='Paid' && $data['apartment_type'] == 'Residential')
    {
      $occupancy = 'All';
      $selected_asset = $data['asset_id'];
      $asset_name = $this->getAsset($selected_asset);
      $payment = $data['payment'];
      $apartment_type = $data['apartment_type'];
    $asset_reports =  Unit::join('tenant_rents as tr','tr.unit_uuid','=','units.uuid')
        ->join('tenants as tn','tn.uuid','=','tr.tenant_uuid')
        ->join('assets','assets.id','=','units.asset_id')
        ->join('landlords as ll','ll.id','=','assets.landlord_id')
        ->join('property_types as pt','pt.id','=','units.property_type_id')
        ->where('units.asset_id',$data['asset_id'])
        ->where('units.user_id',getOwnerUserID())
        ->where('units.apartment_type','Residential')
        ->where('tr.status','Paid')
        ->select('tr.amount as amt','tr.balance as bal','tr.status as payment_status','units.asset_id as assetId','units.quantity as qty','units.quantity_left as qty_left','units.apartment_type as apartmentType','assets.description as assetName','assets.address as locatn','pt.name as proptype', DB::raw('CONCAT(tn.designation, " ", tn.firstname, " ", tn.lastname) as tenantDetail'),DB::raw('CONCAT(ll.designation, " ", ll.firstname, " ", ll.lastname) as landlordDetail'))
        ->get();
  return view('new.admin.reports.asset_report',compact('asset_reports','occupancy','selected_asset','payment','apartment_type','asset_name'));
}elseif($data['asset_id'] !=='' && $data['occupancy'] =='Occupied' && $data['payment'] =='Paid' && $data['apartment_type'] == 'Residential')
    {
      $occupancy = 'Occupied';
      $selected_asset = $data['asset_id'];
      $asset_name = $this->getAsset($selected_asset);
      $payment = $data['payment'];
      $apartment_type = $data['apartment_type'];
    $asset_reports =  Unit::join('tenant_rents as tr','tr.unit_uuid','=','units.uuid')
        ->join('tenants as tn','tn.uuid','=','tr.tenant_uuid')
        ->join('assets','assets.id','=','units.asset_id')
        ->join('landlords as ll','ll.id','=','assets.landlord_id')
        ->join('property_types as pt','pt.id','=','units.property_type_id')
        ->where('units.asset_id',$data['asset_id'])
        ->where('units.user_id',getOwnerUserID())
        ->where('units.quantity_left','<=','0')
        ->where('units.apartment_type','Residential')
        ->where('tr.status','Paid')
        ->select('tr.amount as amt','tr.balance as bal','tr.status as payment_status','units.asset_id as assetId','units.quantity as qty','units.quantity_left as qty_left','units.apartment_type as apartmentType','assets.description as assetName','assets.address as locatn','pt.name as proptype', DB::raw('CONCAT(tn.designation, " ", tn.firstname, " ", tn.lastname) as tenantDetail'),DB::raw('CONCAT(ll.designation, " ", ll.firstname, " ", ll.lastname) as landlordDetail'))
        ->get();
  return view('new.admin.reports.asset_report',compact('asset_reports','occupancy','selected_asset','payment','apartment_type','asset_name'));
}elseif($data['asset_id'] !=='' && $data['occupancy'] =='Occupied' && $data['payment'] =='Paid' && $data['apartment_type'] == 'Commercial')
    {
      $occupancy = 'Occupied';
      $selected_asset = $data['asset_id'];
      $asset_name = $this->getAsset($selected_asset);
      $payment = $data['payment'];
      $apartment_type = $data['apartment_type'];
    $asset_reports =  Unit::join('tenant_rents as tr','tr.unit_uuid','=','units.uuid')
        ->join('tenants as tn','tn.uuid','=','tr.tenant_uuid')
        ->join('assets','assets.id','=','units.asset_id')
        ->join('landlords as ll','ll.id','=','assets.landlord_id')
        ->join('property_types as pt','pt.id','=','units.property_type_id')
        ->where('units.asset_id',$data['asset_id'])
        ->where('units.user_id',getOwnerUserID())
        ->where('units.quantity_left','<=','0')
        ->where('units.apartment_type','Commercial')
        ->where('tr.status','Paid')
        ->select('tr.amount as amt','tr.balance as bal','tr.status as payment_status','units.asset_id as assetId','units.quantity as qty','units.quantity_left as qty_left','units.apartment_type as apartmentType','assets.description as assetName','assets.address as locatn','pt.name as proptype', DB::raw('CONCAT(tn.designation, " ", tn.firstname, " ", tn.lastname) as tenantDetail'),DB::raw('CONCAT(ll.designation, " ", ll.firstname, " ", ll.lastname) as landlordDetail'))
        ->get();
  return view('new.admin.reports.asset_report',compact('asset_reports','occupancy','selected_asset','payment','apartment_type','asset_name'));
}elseif($data['asset_id'] !=='' && $data['occupancy'] =='Occupied' && $data['payment'] =='Partly' && $data['apartment_type'] == 'Commercial')
    {
      $occupancy = 'Occupied';
      $selected_asset = $data['asset_id'];
      $asset_name = $this->getAsset($selected_asset);
      $payment = $data['payment'];
      $apartment_type = $data['apartment_type'];
    $asset_reports =  Unit::join('tenant_rents as tr','tr.unit_uuid','=','units.uuid')
        ->join('tenants as tn','tn.uuid','=','tr.tenant_uuid')
        ->join('assets','assets.id','=','units.asset_id')
        ->join('landlords as ll','ll.id','=','assets.landlord_id')
        ->join('property_types as pt','pt.id','=','units.property_type_id')
        ->where('units.asset_id',$data['asset_id'])
        ->where('units.user_id',getOwnerUserID())
        ->where('units.quantity_left','<=','0')
        ->where('units.apartment_type','Commercial')
        ->where('tr.status','Partly paid')
        ->select('tr.amount as amt','tr.balance as bal','tr.status as payment_status','units.asset_id as assetId','units.quantity as qty','units.quantity_left as qty_left','units.apartment_type as apartmentType','assets.description as assetName','assets.address as locatn','pt.name as proptype', DB::raw('CONCAT(tn.designation, " ", tn.firstname, " ", tn.lastname) as tenantDetail'),DB::raw('CONCAT(ll.designation, " ", ll.firstname, " ", ll.lastname) as landlordDetail'))
        ->get();
  return view('new.admin.reports.asset_report',compact('asset_reports','occupancy','selected_asset','payment','apartment_type','asset_name'));
}elseif($data['asset_id'] !=='' && $data['occupancy'] =='Occupied' && $data['payment'] =='Partly' && $data['apartment_type'] == 'Residential')
    {
      $occupancy = 'Occupied';
      $selected_asset = $data['asset_id'];
      $asset_name = $this->getAsset($selected_asset);
      $payment = $data['payment'];
      $apartment_type = $data['apartment_type'];
    $asset_reports =  Unit::join('tenant_rents as tr','tr.unit_uuid','=','units.uuid')
        ->join('tenants as tn','tn.uuid','=','tr.tenant_uuid')
        ->join('assets','assets.id','=','units.asset_id')
        ->join('landlords as ll','ll.id','=','assets.landlord_id')
        ->join('property_types as pt','pt.id','=','units.property_type_id')
        ->where('units.asset_id',$data['asset_id'])
        ->where('units.user_id',getOwnerUserID())
        ->where('units.quantity_left','<=','0')
        ->where('units.apartment_type','Residential')
        ->where('tr.status','Partly paid')
        ->select('tr.amount as amt','tr.balance as bal','tr.status as payment_status','units.asset_id as assetId','units.quantity as qty','units.quantity_left as qty_left','units.apartment_type as apartmentType','assets.description as assetName','assets.address as locatn','pt.name as proptype', DB::raw('CONCAT(tn.designation, " ", tn.firstname, " ", tn.lastname) as tenantDetail'),DB::raw('CONCAT(ll.designation, " ", ll.firstname, " ", ll.lastname) as landlordDetail'))
        ->get();
  return view('new.admin.reports.asset_report',compact('asset_reports','occupancy','selected_asset','payment','apartment_type','asset_name'));
}elseif($data['asset_id'] !=='' && $data['occupancy'] =='Occupied' && $data['payment'] =='Unpaid' && $data['apartment_type'] == 'Residential')
    {
      $occupancy = 'Occupied';
      $selected_asset = $data['asset_id'];
      $asset_name = $this->getAsset($selected_asset);
      $payment = $data['payment'];
      $apartment_type = $data['apartment_type'];
    $asset_reports =  Unit::join('tenant_rents as tr','tr.unit_uuid','=','units.uuid')
        ->join('tenants as tn','tn.uuid','=','tr.tenant_uuid')
        ->join('assets','assets.id','=','units.asset_id')
        ->join('landlords as ll','ll.id','=','assets.landlord_id')
        ->join('property_types as pt','pt.id','=','units.property_type_id')
        ->where('units.asset_id',$data['asset_id'])
        ->where('units.user_id',getOwnerUserID())
        ->where('units.quantity_left','<=','0')
        ->where('units.apartment_type','Residential')
        ->where('tr.status','pending')
        ->select('tr.amount as amt','tr.balance as bal','tr.status as payment_status','units.asset_id as assetId','units.quantity as qty','units.quantity_left as qty_left','units.apartment_type as apartmentType','assets.description as assetName','assets.address as locatn','pt.name as proptype', DB::raw('CONCAT(tn.designation, " ", tn.firstname, " ", tn.lastname) as tenantDetail'),DB::raw('CONCAT(ll.designation, " ", ll.firstname, " ", ll.lastname) as landlordDetail'))
        ->get();
  return view('new.admin.reports.asset_report',compact('asset_reports','occupancy','selected_asset','payment','apartment_type','asset_name'));
}elseif($data['asset_id'] !=='' && $data['occupancy'] =='Occupied' && $data['payment'] =='Unpaid' && $data['apartment_type'] == 'Commercial')
    {
      $occupancy = 'Occupied';
      $selected_asset = $data['asset_id'];
      $asset_name = $this->getAsset($selected_asset);
      $payment = $data['payment'];
      $apartment_type = $data['apartment_type'];
    $asset_reports =  Unit::join('tenant_rents as tr','tr.unit_uuid','=','units.uuid')
        ->join('tenants as tn','tn.uuid','=','tr.tenant_uuid')
        ->join('assets','assets.id','=','units.asset_id')
        ->join('landlords as ll','ll.id','=','assets.landlord_id')
        ->join('property_types as pt','pt.id','=','units.property_type_id')
        ->where('units.asset_id',$data['asset_id'])
        ->where('units.user_id',getOwnerUserID())
        ->where('units.quantity_left','<=','0')
        ->where('units.apartment_type','Commercial')
        ->where('tr.status','pending')
        ->select('tr.amount as amt','tr.balance as bal','tr.status as payment_status','units.asset_id as assetId','units.quantity as qty','units.quantity_left as qty_left','units.apartment_type as apartmentType','assets.description as assetName','assets.address as locatn','pt.name as proptype', DB::raw('CONCAT(tn.designation, " ", tn.firstname, " ", tn.lastname) as tenantDetail'),DB::raw('CONCAT(ll.designation, " ", ll.firstname, " ", ll.lastname) as landlordDetail'))
        ->get();
  return view('new.admin.reports.asset_report',compact('asset_reports','occupancy','selected_asset','payment','apartment_type','asset_name'));
}elseif($data['asset_id'] !=='' && $data['occupancy'] =='All' && $data['payment'] =='Unpaid' && $data['apartment_type'] == 'Commercial')
    {
      $occupancy = 'All';
      $selected_asset = $data['asset_id'];
      $asset_name = $this->getAsset($selected_asset);
      $payment = $data['payment'];
      $apartment_type = $data['apartment_type'];
    $asset_reports =  Unit::join('tenant_rents as tr','tr.unit_uuid','=','units.uuid')
        ->join('tenants as tn','tn.uuid','=','tr.tenant_uuid')
        ->join('assets','assets.id','=','units.asset_id')
        ->join('landlords as ll','ll.id','=','assets.landlord_id')
        ->join('property_types as pt','pt.id','=','units.property_type_id')
        ->where('units.asset_id',$data['asset_id'])
        ->where('units.user_id',getOwnerUserID())
        ->where('units.apartment_type','Commercial')
        ->where('tr.status','Unpaid')
        ->select('tr.amount as amt','tr.balance as bal','tr.status as payment_status','units.asset_id as assetId','units.quantity as qty','units.quantity_left as qty_left','units.apartment_type as apartmentType','assets.description as assetName','assets.address as locatn','pt.name as proptype', DB::raw('CONCAT(tn.designation, " ", tn.firstname, " ", tn.lastname) as tenantDetail'),DB::raw('CONCAT(ll.designation, " ", ll.firstname, " ", ll.lastname) as landlordDetail'))
        ->get();
  return view('new.admin.reports.asset_report',compact('asset_reports','occupancy','selected_asset','payment','apartment_type','asset_name'));
}elseif($data['asset_id'] !=='' && $data['occupancy'] =='All' && $data['payment'] =='Unpaid' && $data['apartment_type'] == 'Residential')
    {
      $occupancy = 'All';
      $selected_asset = $data['asset_id'];
      $asset_name = $this->getAsset($selected_asset);
      $payment = $data['payment'];
      $apartment_type = $data['apartment_type'];
    $asset_reports =  Unit::join('tenant_rents as tr','tr.unit_uuid','=','units.uuid')
        ->join('tenants as tn','tn.uuid','=','tr.tenant_uuid')
        ->join('assets','assets.id','=','units.asset_id')
        ->join('landlords as ll','ll.id','=','assets.landlord_id')
        ->join('property_types as pt','pt.id','=','units.property_type_id')
        ->where('units.asset_id',$data['asset_id'])
        ->where('units.user_id',getOwnerUserID())
        ->where('units.apartment_type','Residential')
        ->where('tr.status','Unpaid')
        ->select('tr.amount as amt','tr.balance as bal','tr.status as payment_status','units.asset_id as assetId','units.quantity as qty','units.quantity_left as qty_left','units.apartment_type as apartmentType','assets.description as assetName','assets.address as locatn','pt.name as proptype', DB::raw('CONCAT(tn.designation, " ", tn.firstname, " ", tn.lastname) as tenantDetail'),DB::raw('CONCAT(ll.designation, " ", ll.firstname, " ", ll.lastname) as landlordDetail'))
        ->get();
  return view('new.admin.reports.asset_report',compact('asset_reports','occupancy','selected_asset','payment','apartment_type','asset_name'));
}elseif($data['asset_id'] !=='' && $data['occupancy'] =='All' && $data['payment'] =='Partly' && $data['apartment_type'] == 'Commercial')
    {
      $occupancy = 'All';
      $selected_asset = $data['asset_id'];
      $asset_name = $this->getAsset($selected_asset);
      $payment = $data['payment'];
      $apartment_type = $data['apartment_type'];
    $asset_reports =  Unit::join('tenant_rents as tr','tr.unit_uuid','=','units.uuid')
        ->join('tenants as tn','tn.uuid','=','tr.tenant_uuid')
        ->join('assets','assets.id','=','units.asset_id')
        ->join('landlords as ll','ll.id','=','assets.landlord_id')
        ->join('property_types as pt','pt.id','=','units.property_type_id')
        ->where('units.asset_id',$data['asset_id'])
        ->where('units.user_id',getOwnerUserID())
        ->where('units.apartment_type','Commercial')
        ->where('tr.status','Partly Paid')
        ->select('tr.amount as amt','tr.balance as bal','tr.status as payment_status','units.asset_id as assetId','units.quantity as qty','units.quantity_left as qty_left','units.apartment_type as apartmentType','assets.description as assetName','assets.address as locatn','pt.name as proptype', DB::raw('CONCAT(tn.designation, " ", tn.firstname, " ", tn.lastname) as tenantDetail'),DB::raw('CONCAT(ll.designation, " ", ll.firstname, " ", ll.lastname) as landlordDetail'))
        ->get();
  return view('new.admin.reports.asset_report',compact('asset_reports','occupancy','selected_asset','payment','apartment_type','asset_name'));
}elseif($data['asset_id'] !=='' && $data['occupancy'] =='All' && $data['payment'] =='Partly' && $data['apartment_type'] == 'Residential')
    {
      $occupancy = 'All';
      $selected_asset = $data['asset_id'];
      $asset_name = $this->getAsset($selected_asset);
      $payment = $data['payment'];
      $apartment_type = $data['apartment_type'];
    $asset_reports =  Unit::join('tenant_rents as tr','tr.unit_uuid','=','units.uuid')
        ->join('tenants as tn','tn.uuid','=','tr.tenant_uuid')
        ->join('assets','assets.id','=','units.asset_id')
        ->join('landlords as ll','ll.id','=','assets.landlord_id')
        ->join('property_types as pt','pt.id','=','units.property_type_id')
        ->where('units.asset_id',$data['asset_id'])
        ->where('units.user_id',getOwnerUserID())
        ->where('units.apartment_type','Residential')
        ->where('tr.status','Partly Paid')
        ->select('tr.amount as amt','tr.balance as bal','tr.status as payment_status','units.asset_id as assetId','units.quantity as qty','units.quantity_left as qty_left','units.apartment_type as apartmentType','assets.description as assetName','assets.address as locatn','pt.name as proptype', DB::raw('CONCAT(tn.designation, " ", tn.firstname, " ", tn.lastname) as tenantDetail'),DB::raw('CONCAT(ll.designation, " ", ll.firstname, " ", ll.lastname) as landlordDetail'))
        ->get();
  return view('new.admin.reports.asset_report',compact('asset_reports','occupancy','selected_asset','payment','apartment_type','asset_name'));
}

 return view('new.admin.reports.asset_report');
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
