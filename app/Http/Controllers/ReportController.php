<?php

namespace App\Http\Controllers;

use App\Asset;
use App\Report_objects\Portfolio;
use App\Tenant;
use App\TenantRent;
use App\TenantServiceCharge;
use App\Unit;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\collection;
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
        ->join('cities as ct','ct.id','=','assets.city_id')
        ->where('units.asset_id',$data['asset_id'])
        ->where('units.user_id',getOwnerUserID())
        ->where('units.apartment_type','Commercial')
        ->select('tr.amount as amt','tr.balance as bal','tr.status as payment_status','units.asset_id as assetId','units.quantity as qty','units.quantity_left as qty_left','units.apartment_type as apartmentType','assets.description as assetName','assets.address as locatn','ct.name as cityName','pt.name as proptype', DB::raw('CONCAT(tn.designation, " ", tn.firstname, " ", tn.lastname) as tenantDetail'),DB::raw('CONCAT(ll.designation, " ", ll.firstname, " ", ll.lastname) as landlordDetail'))
        ->get();
  return view('new.admin.reports.asset_report',compact('asset_reports','occupancy','selected_asset','payment','apartment_type','asset_name'));
}elseif($data['asset_id'] =='All' && $data['occupancy'] =='All' && $data['payment'] =='All' && $data['apartment_type'] == 'All')
    {
      $occupancy = 'All';
      $asset_option = 'All';
      $selected_asset = $data['asset_id'];
      $asset_name = $this->getAsset($selected_asset);
      $payment = $data['payment'];
      $apartment_type = $data['apartment_type'];
    $asset_reports =  Unit::join('tenant_rents as tr','tr.unit_uuid','=','units.uuid')
        ->join('tenants as tn','tn.uuid','=','tr.tenant_uuid')
        ->join('assets','assets.id','=','units.asset_id')
        ->join('landlords as ll','ll.id','=','assets.landlord_id')
        ->join('property_types as pt','pt.id','=','units.property_type_id')
        ->join('cities as ct','ct.id','=','assets.city_id')
        // ->where('units.asset_id',$data['asset_id'])
        ->where('units.user_id',getOwnerUserID())
        // ->where('units.apartment_type','Commercial')
        ->select('tr.amount as amt','tr.balance as bal','tr.status as payment_status','units.asset_id as assetId','units.quantity as qty','units.quantity_left as qty_left','units.apartment_type as apartmentType','assets.description as assetName','assets.address as locatn','ct.name as cityName','pt.name as proptype', DB::raw('CONCAT(tn.designation, " ", tn.firstname, " ", tn.lastname) as tenantDetail'),DB::raw('CONCAT(ll.designation, " ", ll.firstname, " ", ll.lastname) as landlordDetail'))
        ->get();
  return view('new.admin.reports.asset_report',compact('asset_reports','occupancy','selected_asset','payment','apartment_type','asset_name','asset_option'));
}


elseif($data['asset_id'] !=='' && $data['occupancy'] =='All' && $data['payment'] =='All' && $data['apartment_type'] == 'All')
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
        ->join('cities as ct','ct.id','=','assets.city_id')
        ->where('units.asset_id',$data['asset_id'])
        ->where('units.user_id',getOwnerUserID())
        ->select('tr.amount as amt','tr.balance as bal','tr.status as payment_status','units.asset_id as assetId','units.quantity as qty','units.quantity_left as qty_left','units.apartment_type as apartmentType','assets.description as assetName','assets.address as locatn','ct.name as cityName','pt.name as proptype', DB::raw('CONCAT(tn.designation, " ", tn.firstname, " ", tn.lastname) as tenantDetail'),DB::raw('CONCAT(ll.designation, " ", ll.firstname, " ", ll.lastname) as landlordDetail'))
        ->get();
  return view('new.admin.reports.asset_report',compact('asset_reports','occupancy','selected_asset','payment','apartment_type','asset_name'));
}
elseif($data['asset_id'] !=='' && $data['occupancy'] =='Occupied' && $data['payment'] =='All' && $data['apartment_type'] == 'Commercial')
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
         ->join('cities as ct','ct.id','=','assets.city_id')
        ->where('units.asset_id',$data['asset_id'])
        ->where('units.user_id',getOwnerUserID())
        ->where('units.quantity_left','<=','0')
        ->where('units.apartment_type','Commercial')
        ->select('tr.amount as amt','tr.balance as bal','tr.status as payment_status','units.asset_id as assetId','units.quantity as qty','units.quantity_left as qty_left','units.apartment_type as apartmentType','assets.description as assetName','assets.address as locatn','ct.name as cityName','pt.name as proptype', DB::raw('CONCAT(tn.designation, " ", tn.firstname, " ", tn.lastname) as tenantDetail'),DB::raw('CONCAT(ll.designation, " ", ll.firstname, " ", ll.lastname) as landlordDetail'))
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
        ->join('cities as ct','ct.id','=','assets.city_id')
        ->where('units.asset_id',$data['asset_id'])
        ->where('units.user_id',getOwnerUserID())
        ->where('units.quantity_left','>=','1')
        ->where('units.apartment_type','Commercial')
        ->select('tr.amount as amt','tr.balance as bal','tr.status as payment_status','units.asset_id as assetId','units.quantity as qty','units.quantity_left as qty_left','units.apartment_type as apartmentType','assets.description as assetName','assets.address as locatn','ct.name as cityName','pt.name as proptype', DB::raw('CONCAT(tn.designation, " ", tn.firstname, " ", tn.lastname) as tenantDetail'),DB::raw('CONCAT(ll.designation, " ", ll.firstname, " ", ll.lastname) as landlordDetail'))
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
         ->join('cities as ct','ct.id','=','assets.city_id')
        ->where('units.asset_id',$data['asset_id'])
        ->where('units.user_id',getOwnerUserID())
        ->where('units.apartment_type','Residential')
        ->select('tr.amount as amt','tr.balance as bal','tr.status as payment_status','units.asset_id as assetId','units.quantity as qty','units.quantity_left as qty_left','units.apartment_type as apartmentType','assets.description as assetName','assets.address as locatn','ct.name as cityName','pt.name as proptype', DB::raw('CONCAT(tn.designation, " ", tn.firstname, " ", tn.lastname) as tenantDetail'),DB::raw('CONCAT(ll.designation, " ", ll.firstname, " ", ll.lastname) as landlordDetail'))
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
         ->join('cities as ct','ct.id','=','assets.city_id')
        ->where('units.asset_id',$data['asset_id'])
        ->where('units.user_id',getOwnerUserID())
        ->where('units.quantity_left','<=','0')
        ->where('units.apartment_type','Residential')
        ->select('tr.amount as amt','tr.balance as bal','tr.status as payment_status','units.asset_id as assetId','units.quantity as qty','units.quantity_left as qty_left','units.apartment_type as apartmentType','assets.description as assetName','assets.address as locatn','ct.name as cityName','pt.name as proptype', DB::raw('CONCAT(tn.designation, " ", tn.firstname, " ", tn.lastname) as tenantDetail'),DB::raw('CONCAT(ll.designation, " ", ll.firstname, " ", ll.lastname) as landlordDetail'))
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
        ->join('cities as ct','ct.id','=','assets.city_id')
        ->where('units.asset_id',$data['asset_id'])
        ->where('units.user_id',getOwnerUserID())
        ->where('units.quantity_left','>','0')
        ->where('units.apartment_type','Residential')
        ->select('tr.amount as amt','tr.balance as bal','tr.status as payment_status','units.asset_id as assetId','units.quantity as qty','units.quantity_left as qty_left','units.apartment_type as apartmentType','assets.description as assetName','assets.address as locatn','ct.name as cityName','pt.name as proptype', DB::raw('CONCAT(tn.designation, " ", tn.firstname, " ", tn.lastname) as tenantDetail'),DB::raw('CONCAT(ll.designation, " ", ll.firstname, " ", ll.lastname) as landlordDetail'))
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
        ->join('cities as ct','ct.id','=','assets.city_id')
        ->where('units.asset_id',$data['asset_id'])
        ->where('units.user_id',getOwnerUserID())
        ->where('units.apartment_type','Commercial')
        ->where('tr.status','Paid')
        ->select('tr.amount as amt','tr.balance as bal','tr.status as payment_status','units.asset_id as assetId','units.quantity as qty','units.quantity_left as qty_left','units.apartment_type as apartmentType','assets.description as assetName','assets.address as locatn','ct.name as cityName','pt.name as proptype', DB::raw('CONCAT(tn.designation, " ", tn.firstname, " ", tn.lastname) as tenantDetail'),DB::raw('CONCAT(ll.designation, " ", ll.firstname, " ", ll.lastname) as landlordDetail'))
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
        ->join('cities as ct','ct.id','=','assets.city_id')
        ->where('units.asset_id',$data['asset_id'])
        ->where('units.user_id',getOwnerUserID())
        ->where('units.apartment_type','Residential')
        ->where('tr.status','Paid')
        ->select('tr.amount as amt','tr.balance as bal','tr.status as payment_status','units.asset_id as assetId','units.quantity as qty','units.quantity_left as qty_left','units.apartment_type as apartmentType','assets.description as assetName','assets.address as locatn','ct.name as cityName','pt.name as proptype', DB::raw('CONCAT(tn.designation, " ", tn.firstname, " ", tn.lastname) as tenantDetail'),DB::raw('CONCAT(ll.designation, " ", ll.firstname, " ", ll.lastname) as landlordDetail'))
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
        ->join('cities as ct','ct.id','=','assets.city_id')
        ->where('units.asset_id',$data['asset_id'])
        ->where('units.user_id',getOwnerUserID())
        ->where('units.quantity_left','<=','0')
        ->where('units.apartment_type','Residential')
        ->where('tr.status','Paid')
        ->select('tr.amount as amt','tr.balance as bal','tr.status as payment_status','units.asset_id as assetId','units.quantity as qty','units.quantity_left as qty_left','units.apartment_type as apartmentType','assets.description as assetName','assets.address as locatn','ct.name as cityName','pt.name as proptype', DB::raw('CONCAT(tn.designation, " ", tn.firstname, " ", tn.lastname) as tenantDetail'),DB::raw('CONCAT(ll.designation, " ", ll.firstname, " ", ll.lastname) as landlordDetail'))
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
        ->join('cities as ct','ct.id','=','assets.city_id')
        ->where('units.asset_id',$data['asset_id'])
        ->where('units.user_id',getOwnerUserID())
        ->where('units.quantity_left','<=','0')
        ->where('units.apartment_type','Commercial')
        ->where('tr.status','Paid')
        ->select('tr.amount as amt','tr.balance as bal','tr.status as payment_status','units.asset_id as assetId','units.quantity as qty','units.quantity_left as qty_left','units.apartment_type as apartmentType','assets.description as assetName','assets.address as locatn','ct.name as cityName','pt.name as proptype', DB::raw('CONCAT(tn.designation, " ", tn.firstname, " ", tn.lastname) as tenantDetail'),DB::raw('CONCAT(ll.designation, " ", ll.firstname, " ", ll.lastname) as landlordDetail'))
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
        ->join('cities as ct','ct.id','=','assets.city_id')
        ->where('units.asset_id',$data['asset_id'])
        ->where('units.user_id',getOwnerUserID())
        ->where('units.quantity_left','<=','0')
        ->where('units.apartment_type','Commercial')
        ->where('tr.status','Partly paid')
        ->select('tr.amount as amt','tr.balance as bal','tr.status as payment_status','units.asset_id as assetId','units.quantity as qty','units.quantity_left as qty_left','units.apartment_type as apartmentType','assets.description as assetName','assets.address as locatn','ct.name as cityName','pt.name as proptype', DB::raw('CONCAT(tn.designation, " ", tn.firstname, " ", tn.lastname) as tenantDetail'),DB::raw('CONCAT(ll.designation, " ", ll.firstname, " ", ll.lastname) as landlordDetail'))
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
        ->join('cities as ct','ct.id','=','assets.city_id')
        ->where('units.asset_id',$data['asset_id'])
        ->where('units.user_id',getOwnerUserID())
        ->where('units.quantity_left','<=','0')
        ->where('units.apartment_type','Residential')
        ->where('tr.status','Partly paid')
        ->select('tr.amount as amt','tr.balance as bal','tr.status as payment_status','units.asset_id as assetId','units.quantity as qty','units.quantity_left as qty_left','units.apartment_type as apartmentType','assets.description as assetName','assets.address as locatn','ct.name as cityName','pt.name as proptype', DB::raw('CONCAT(tn.designation, " ", tn.firstname, " ", tn.lastname) as tenantDetail'),DB::raw('CONCAT(ll.designation, " ", ll.firstname, " ", ll.lastname) as landlordDetail'))
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
        ->join('cities as ct','ct.id','=','assets.city_id')
        ->where('units.asset_id',$data['asset_id'])
        ->where('units.user_id',getOwnerUserID())
        ->where('units.quantity_left','<=','0')
        ->where('units.apartment_type','Residential')
        ->where('tr.status','pending')
        ->select('tr.amount as amt','tr.balance as bal','tr.status as payment_status','units.asset_id as assetId','units.quantity as qty','units.quantity_left as qty_left','units.apartment_type as apartmentType','assets.description as assetName','assets.address as locatn','ct.name as cityName','pt.name as proptype', DB::raw('CONCAT(tn.designation, " ", tn.firstname, " ", tn.lastname) as tenantDetail'),DB::raw('CONCAT(ll.designation, " ", ll.firstname, " ", ll.lastname) as landlordDetail'))
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
        ->join('cities as ct','ct.id','=','assets.city_id')
        ->where('units.asset_id',$data['asset_id'])
        ->where('units.user_id',getOwnerUserID())
        ->where('units.quantity_left','<=','0')
        ->where('units.apartment_type','Commercial')
        ->where('tr.status','pending')
        ->select('tr.amount as amt','tr.balance as bal','tr.status as payment_status','units.asset_id as assetId','units.quantity as qty','units.quantity_left as qty_left','units.apartment_type as apartmentType','assets.description as assetName','assets.address as locatn','ct.name as cityName','pt.name as proptype', DB::raw('CONCAT(tn.designation, " ", tn.firstname, " ", tn.lastname) as tenantDetail'),DB::raw('CONCAT(ll.designation, " ", ll.firstname, " ", ll.lastname) as landlordDetail'))
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
        ->join('cities as ct','ct.id','=','assets.city_id')
        ->where('units.asset_id',$data['asset_id'])
        ->where('units.user_id',getOwnerUserID())
        ->where('units.apartment_type','Commercial')
        ->where('tr.status','Unpaid')
        ->select('tr.amount as amt','tr.balance as bal','tr.status as payment_status','units.asset_id as assetId','units.quantity as qty','units.quantity_left as qty_left','units.apartment_type as apartmentType','assets.description as assetName','assets.address as locatn','ct.name as cityName','pt.name as proptype', DB::raw('CONCAT(tn.designation, " ", tn.firstname, " ", tn.lastname) as tenantDetail'),DB::raw('CONCAT(ll.designation, " ", ll.firstname, " ", ll.lastname) as landlordDetail'))
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
        ->join('cities as ct','ct.id','=','assets.city_id')
        ->join('property_types as pt','pt.id','=','units.property_type_id')
        ->where('units.asset_id',$data['asset_id'])
        ->where('units.user_id',getOwnerUserID())
        ->where('units.apartment_type','Residential')
        ->where('tr.status','Unpaid')
        ->select('tr.amount as amt','tr.balance as bal','tr.status as payment_status','units.asset_id as assetId','units.quantity as qty','units.quantity_left as qty_left','units.apartment_type as apartmentType','assets.description as assetName','assets.address as locatn','ct.name as cityName','pt.name as proptype', DB::raw('CONCAT(tn.designation, " ", tn.firstname, " ", tn.lastname) as tenantDetail'),DB::raw('CONCAT(ll.designation, " ", ll.firstname, " ", ll.lastname) as landlordDetail'))
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
        ->join('cities as ct','ct.id','=','assets.city_id')
        ->where('units.asset_id',$data['asset_id'])
        ->where('units.user_id',getOwnerUserID())
        ->where('units.apartment_type','Commercial')
        ->where('tr.status','Partly Paid')
        ->select('tr.amount as amt','tr.balance as bal','tr.status as payment_status','units.asset_id as assetId','units.quantity as qty','units.quantity_left as qty_left','units.apartment_type as apartmentType','assets.description as assetName','assets.address as locatn','ct.name as cityName','pt.name as proptype', DB::raw('CONCAT(tn.designation, " ", tn.firstname, " ", tn.lastname) as tenantDetail'),DB::raw('CONCAT(ll.designation, " ", ll.firstname, " ", ll.lastname) as landlordDetail'))
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
        ->join('cities as ct','ct.id','=','assets.city_id')
        ->where('units.asset_id',$data['asset_id'])
        ->where('units.user_id',getOwnerUserID())
        ->where('units.apartment_type','Residential')
        ->where('tr.status','Partly Paid')
        ->select('tr.amount as amt','tr.balance as bal','tr.status as payment_status','units.asset_id as assetId','units.quantity as qty','units.quantity_left as qty_left','units.apartment_type as apartmentType','assets.description as assetName','assets.address as locatn','ct.name as cityName','pt.name as proptype', DB::raw('CONCAT(tn.designation, " ", tn.firstname, " ", tn.lastname) as tenantDetail'),DB::raw('CONCAT(ll.designation, " ", ll.firstname, " ", ll.lastname) as landlordDetail'))
        ->get();
  return view('new.admin.reports.asset_report',compact('asset_reports','occupancy','selected_asset','payment','apartment_type','asset_name'));
}

 return view('new.admin.reports.asset_report');
  }

public function landlordReport(Request $request) {

      $start_date = '';
      $end_date = '';
      $selected_tenant = '';
      $tenant_name = '';
      $rental = '';
      $service_charge = '';
  return view('new.admin.reports.landlord_report',compact('start_date','end_date','selected_tenant','rental','service_charge','tenant_name'));

  }

  public function getLandlordReport(Request $request) {
    $data = $request->all();

    $start_date = Carbon::parse(formatDate($data['startDate'], 'd/m/Y', 'Y-m-d'));
    $end_date   = Carbon::parse(formatDate($data['dueDate'], 'd/m/Y', 'Y-m-d'));

     if($end_date < $start_date){
        return back()->withInput()->with('error','End Date cannot be less than start date');
    }


    $selected_tenant = '';
    $tenant_name = '';
    $rental = '';
    $service_charge = '';

    $tenant_rentDetails = TenantRent::join('assets','assets.uuid','=','tenant_rents.asset_uuid')
                    ->join('landlords as ll','ll.id','=','assets.landlord_id')
                    ->join('units','units.uuid','=','tenant_rents.unit_uuid')
                    ->join('property_types as pt','pt.id','=','units.property_type_id')
                    ->join('tenants as tn','tn.uuid','=','tenant_rents.tenant_uuid')
                    // ->join('tenant_service_charges as tsc','tn.id','=','tsc.tenant_id')
                    ->whereBetween('tenant_rents.due_date',[$start_date,$end_date])
                    ->where('tenant_rents.balance','>',0)
                    ->select('tenant_rents.*','assets.description as assetdesc','tenant_rents.due_date as rentExp','tenant_rents.balance as outstandingRent',DB::raw('CONCAT(tn.designation, " ", tn.firstname, " ", tn.lastname) as tenantDetail'),DB::raw('CONCAT(ll.designation, " ", ll.firstname, " ", ll.lastname) as landlordDetail'),'units.apartment_type as apartmentType','units.apartment_type as apartmentType','pt.name as proptype')
                    ->get();
    
  return view('new.admin.reports.landlord_report',compact('tenant_rentDetails','start_date','end_date','selected_tenant','rental','service_charge','tenant_name'));
  }
    public function rentalReport()
    {
      $start_date = '';
      $end_date = '';
      $selected_tenant = '';
      $tenant_name = '';
      $rental = '';
      $apartment_type = '';
         return view('new.admin.reports.rental_report',compact('start_date','end_date','selected_tenant','rental','apartment_type','tenant_name'));
    }


     public function getRentalReport(Request $request) {
    $data = $request->all();

    $start_date = Carbon::parse(formatDate($data['startDate'], 'd/m/Y', 'Y-m-d'));
    $end_date   = Carbon::parse(formatDate($data['dueDate'], 'd/m/Y', 'Y-m-d'));
    $selected_tenant = '';
    $tenant_name = '';
    $rental = '';
    $apartment_type  = '';
     if($end_date < $start_date){
        return back()->withInput()->with('error','End Date cannot be less than start date');
    }

if(isset($start_date) !=='' && isset($end_date) !=='' && $data['rental'] == '' && $data['apartment_type'] == ''){

    $selected_tenant = '';
    $tenant_name = '';
    $rental = '';
    $apartment_type  = '';

    $rental_reportDetails = TenantRent::join('assets','assets.uuid','=','tenant_rents.asset_uuid')
                    ->join('landlords as ll','ll.id','=','assets.landlord_id')
                    ->join('units','units.uuid','=','tenant_rents.unit_uuid')
                    ->join('property_types as pt','pt.id','=','units.property_type_id')
                    ->join('tenants as tn','tn.uuid','=','tenant_rents.tenant_uuid')
                    ->whereBetween('tenant_rents.due_date',[$start_date,$end_date])
                    ->where('tenant_rents.user_id',getOwnerUserID())
                    ->select('tenant_rents.*','assets.description as assetdesc','tenant_rents.due_date as rentExp','tenant_rents.balance as outstandingRent',
                      'tenant_rents.amount as rent_amt',DB::raw('CONCAT(tn.designation, " ", tn.firstname, " ", tn.lastname) as tenantDetail'),DB::raw('CONCAT(ll.designation, " ", ll.firstname, " ", ll.lastname) as landlordDetail'),'units.apartment_type as apartmentType','units.apartment_type as apartmentType','pt.name as proptype','tenant_rents.status as rentStatus')
                    ->get();
    
      return view('new.admin.reports.rental_report',compact('rental_reportDetails','start_date','end_date','selected_tenant','rental','apartment_type','tenant_name'));
  }elseif(isset($start_date) !=='' && isset($end_date) !=='' && $data['rental'] == 'All' && $data['apartment_type'] == ''){

    $selected_tenant = '';
    $tenant_name = '';
    $rental = $data['rental'];
    $apartment_type  = '';

    $rental_reportDetails = TenantRent::join('assets','assets.uuid','=','tenant_rents.asset_uuid')
                    ->join('landlords as ll','ll.id','=','assets.landlord_id')
                    ->join('units','units.uuid','=','tenant_rents.unit_uuid')
                    ->join('property_types as pt','pt.id','=','units.property_type_id')
                    ->join('tenants as tn','tn.uuid','=','tenant_rents.tenant_uuid')
                    ->whereBetween('tenant_rents.due_date',[$start_date,$end_date])
                    ->where('tenant_rents.balance','>=',0)
                    ->where('tenant_rents.user_id',getOwnerUserID())
                    ->select('tenant_rents.*','assets.description as assetdesc','tenant_rents.due_date as rentExp','tenant_rents.balance as outstandingRent',
                      'tenant_rents.amount as rent_amt',DB::raw('CONCAT(tn.designation, " ", tn.firstname, " ", tn.lastname) as tenantDetail'),DB::raw('CONCAT(ll.designation, " ", ll.firstname, " ", ll.lastname) as landlordDetail'),'units.apartment_type as apartmentType','units.apartment_type as apartmentType','pt.name as proptype','tenant_rents.status as rentStatus')
                    ->get();
    // dd($rental_reportDetails);
  return view('new.admin.reports.rental_report',compact('rental_reportDetails','start_date','end_date','selected_tenant','rental','apartment_type','tenant_name'));
  }elseif(isset($start_date) !=='' && isset($end_date) !=='' && $data['rental'] == 'Outstanding' && $data['apartment_type'] == ''){

    $selected_tenant = '';
    $tenant_name = '';
    $rental = $data['rental'];
    $apartment_type  = '';

    $rental_reportDetails = TenantRent::join('assets','assets.uuid','=','tenant_rents.asset_uuid')
                    ->join('landlords as ll','ll.id','=','assets.landlord_id')
                    ->join('units','units.uuid','=','tenant_rents.unit_uuid')
                    ->join('property_types as pt','pt.id','=','units.property_type_id')
                    ->join('tenants as tn','tn.uuid','=','tenant_rents.tenant_uuid')
                    ->whereBetween('tenant_rents.due_date',[$start_date,$end_date])
                    ->where('tenant_rents.balance','>',0)
                    ->where('tenant_rents.user_id',getOwnerUserID())
                    ->select('tenant_rents.*','assets.description as assetdesc','tenant_rents.due_date as rentExp','tenant_rents.balance as outstandingRent',
                      'tenant_rents.amount as rent_amt',DB::raw('CONCAT(tn.designation, " ", tn.firstname, " ", tn.lastname) as tenantDetail'),DB::raw('CONCAT(ll.designation, " ", ll.firstname, " ", ll.lastname) as landlordDetail'),'units.apartment_type as apartmentType','units.apartment_type as apartmentType','pt.name as proptype','tenant_rents.status as rentStatus')
                    ->get();
   
  return view('new.admin.reports.rental_report',compact('rental_reportDetails','start_date','end_date','selected_tenant','rental','apartment_type','tenant_name'));
  }elseif(isset($start_date) !=='' && isset($end_date) !=='' && $data['rental'] == 'Outstanding' && $data['apartment_type'] == 'Commercial'){

    $selected_tenant = '';
    $tenant_name = '';
    $rental = $data['rental'];
    $apartment_type  = $data['apartment_type'];

    $rental_reportDetails = TenantRent::join('assets','assets.uuid','=','tenant_rents.asset_uuid')
                    ->join('landlords as ll','ll.id','=','assets.landlord_id')
                    ->join('units','units.uuid','=','tenant_rents.unit_uuid')
                    ->join('property_types as pt','pt.id','=','units.property_type_id')
                    ->join('tenants as tn','tn.uuid','=','tenant_rents.tenant_uuid')
                    ->whereBetween('tenant_rents.due_date',[$start_date,$end_date])
                    ->where('tenant_rents.balance','>',0)
                    ->where('units.apartment_type','Commercial')
                    ->where('tenant_rents.user_id',getOwnerUserID())
                    ->select('tenant_rents.*','assets.description as assetdesc','tenant_rents.due_date as rentExp','tenant_rents.balance as outstandingRent',
                      'tenant_rents.amount as rent_amt',DB::raw('CONCAT(tn.designation, " ", tn.firstname, " ", tn.lastname) as tenantDetail'),DB::raw('CONCAT(ll.designation, " ", ll.firstname, " ", ll.lastname) as landlordDetail'),'units.apartment_type as apartmentType','units.apartment_type as apartmentType','pt.name as proptype','tenant_rents.status as rentStatus')
                    ->get();
    
  return view('new.admin.reports.rental_report',compact('rental_reportDetails','start_date','end_date','selected_tenant','rental','apartment_type','tenant_name'));
  }elseif(isset($start_date) !=='' && isset($end_date) !=='' && $data['rental'] == 'Outstanding' && $data['apartment_type'] == 'Residential'){

    $selected_tenant = '';
    $tenant_name = '';
    $rental = $data['rental'];
    $apartment_type  = $data['apartment_type'];

    $rental_reportDetails = TenantRent::join('assets','assets.uuid','=','tenant_rents.asset_uuid')
                    ->join('landlords as ll','ll.id','=','assets.landlord_id')
                    ->join('units','units.uuid','=','tenant_rents.unit_uuid')
                    ->join('property_types as pt','pt.id','=','units.property_type_id')
                    ->join('tenants as tn','tn.uuid','=','tenant_rents.tenant_uuid')
                    ->whereBetween('tenant_rents.due_date',[$start_date,$end_date])
                    ->where('tenant_rents.balance','>',0)
                    ->where('units.apartment_type','Residential')
                    ->where('tenant_rents.user_id',getOwnerUserID())
                    ->select('tenant_rents.*','assets.description as assetdesc','tenant_rents.due_date as rentExp','tenant_rents.balance as outstandingRent',
                      'tenant_rents.amount as rent_amt',DB::raw('CONCAT(tn.designation, " ", tn.firstname, " ", tn.lastname) as tenantDetail'),DB::raw('CONCAT(ll.designation, " ", ll.firstname, " ", ll.lastname) as landlordDetail'),'units.apartment_type as apartmentType','units.apartment_type as apartmentType','pt.name as proptype','tenant_rents.status as rentStatus')
                    ->get();

  return view('new.admin.reports.rental_report',compact('rental_reportDetails','start_date','end_date','selected_tenant','rental','apartment_type','tenant_name'));
  }elseif(isset($start_date) !=='' && isset($end_date) !=='' && $data['rental'] == 'All' && $data['apartment_type'] == 'Commercial'){

    $selected_tenant = '';
    $tenant_name = '';
    $rental = $data['rental'];
    $apartment_type  = $data['apartment_type'];

    $rental_reportDetails = TenantRent::join('assets','assets.uuid','=','tenant_rents.asset_uuid')
                    ->join('landlords as ll','ll.id','=','assets.landlord_id')
                    ->join('units','units.uuid','=','tenant_rents.unit_uuid')
                    ->join('property_types as pt','pt.id','=','units.property_type_id')
                    ->join('tenants as tn','tn.uuid','=','tenant_rents.tenant_uuid')
                    ->whereBetween('tenant_rents.due_date',[$start_date,$end_date])
                    ->where('tenant_rents.balance','>=',0)
                    ->where('units.apartment_type','Commercial')
                    ->where('tenant_rents.user_id',getOwnerUserID())
                    ->select('tenant_rents.*','assets.description as assetdesc','tenant_rents.due_date as rentExp','tenant_rents.balance as outstandingRent',
                      'tenant_rents.amount as rent_amt',DB::raw('CONCAT(tn.designation, " ", tn.firstname, " ", tn.lastname) as tenantDetail'),DB::raw('CONCAT(ll.designation, " ", ll.firstname, " ", ll.lastname) as landlordDetail'),'units.apartment_type as apartmentType','units.apartment_type as apartmentType','pt.name as proptype','tenant_rents.status as rentStatus')
                    ->get();

  return view('new.admin.reports.rental_report',compact('rental_reportDetails','start_date','end_date','selected_tenant','rental','apartment_type','tenant_name'));
  }elseif(isset($start_date) !=='' && isset($end_date) !=='' && $data['rental'] == 'All' && $data['apartment_type'] == 'Residential'){

    $selected_tenant = '';
    $tenant_name = '';
    $rental = $data['rental'];
    $apartment_type  = $data['apartment_type'];

    $rental_reportDetails = TenantRent::join('assets','assets.uuid','=','tenant_rents.asset_uuid')
                    ->join('landlords as ll','ll.id','=','assets.landlord_id')
                    ->join('units','units.uuid','=','tenant_rents.unit_uuid')
                    ->join('property_types as pt','pt.id','=','units.property_type_id')
                    ->join('tenants as tn','tn.uuid','=','tenant_rents.tenant_uuid')
                    ->whereBetween('tenant_rents.due_date',[$start_date,$end_date])
                    ->where('tenant_rents.balance','>=',0)
                    ->where('units.apartment_type','Residential')
                    ->where('tenant_rents.user_id',getOwnerUserID())
                    ->select('tenant_rents.*','assets.description as assetdesc','tenant_rents.due_date as rentExp','tenant_rents.balance as outstandingRent',
                      'tenant_rents.amount as rent_amt',DB::raw('CONCAT(tn.designation, " ", tn.firstname, " ", tn.lastname) as tenantDetail'),DB::raw('CONCAT(ll.designation, " ", ll.firstname, " ", ll.lastname) as landlordDetail'),'units.apartment_type as apartmentType','units.apartment_type as apartmentType','pt.name as proptype','tenant_rents.status as rentStatus')
                    ->get();
  return view('new.admin.reports.rental_report',compact('rental_reportDetails','start_date','end_date','selected_tenant','rental','apartment_type','tenant_name'));
  }

  return view('new.admin.reports.rental_report',compact('start_date','end_date','selected_tenant','rental','apartment_type','tenant_name'));
}

public function serviceChargeReport(){

      $start_date = '';
      $end_date = '';
      $selected_tenant = '';
      $tenant_name = '';
      $selected_payment = '';
      $apartment_type = '';
   return view('new.admin.reports.service_charge_report',compact('start_date','end_date','selected_tenant','selected_payment','apartment_type','tenant_name'));
}

public function getServiceChargeReport(Request $request){
  $data = $request->all();


    $start_date = Carbon::parse(formatDate($data['startDate'], 'd/m/Y', 'Y-m-d'));
    $end_date   = Carbon::parse(formatDate($data['dueDate'], 'd/m/Y', 'Y-m-d'));
    $selected_tenant = '';
    $tenant_name = '';
    $selected_payment  = '';
    $apartment_type  = '';
     if($end_date < $start_date){
        return back()->withInput()->with('error','End Date cannot be less than start date');
    }

    if(isset($start_date) !=='' && isset($end_date) !=='' && $data['payment'] == 'All'){
      $selected_payment = $data['payment'];
    $service_charges = TenantServiceCharge::join('asset_service_charges', 'asset_service_charges.id', '=', 'tenant_service_charges.asc_id')
        ->join('tenants','tenants.id','=','tenant_service_charges.tenant_id')
        ->join('service_charges','service_charges.id','=','tenant_service_charges.service_chargeId')
        ->join('assets','assets.id','=','asset_service_charges.asset_id')
        ->join('landlords as ll','ll.id','=','assets.landlord_id')
        ->where('tenant_service_charges.user_id', getOwnerUserID())
        ->whereBetween('asset_service_charges.dueDate',[$start_date,$end_date])
        ->select('tenant_service_charges.bal as serviceChargeBal','asset_service_charges.price as total','asset_service_charges.balance as asc_bal','asset_service_charges.payment_status as paymentStatus','service_charges.name as serviceCharge','assets.description as assetName',DB::raw('CONCAT(ll.designation, " ", ll.firstname, " ", ll.lastname) as landlordDetail'),DB::raw('CONCAT(tenants.designation, " ", tenants.firstname, " ", tenants.lastname) as tenantDetail'))
         ->get();
  return view('new.admin.reports.service_charge_report',compact('service_charges','start_date','end_date','selected_tenant','selected_payment','apartment_type','tenant_name'));
}elseif(isset($start_date) !=='' && isset($end_date) !=='' && $data['payment'] == 'Paid'){
      $selected_payment = $data['payment'];
$service_charges = TenantServiceCharge::join('asset_service_charges', 'asset_service_charges.id', '=', 'tenant_service_charges.asc_id')
        ->join('tenants','tenants.id','=','tenant_service_charges.tenant_id')
        ->join('service_charges','service_charges.id','=','tenant_service_charges.service_chargeId')
        ->join('assets','assets.id','=','asset_service_charges.asset_id')
        ->join('landlords as ll','ll.id','=','assets.landlord_id')
        ->where('tenant_service_charges.user_id', getOwnerUserID())
        ->where('asset_service_charges.payment_status', 'Paid')
        ->whereBetween('asset_service_charges.dueDate',[$start_date,$end_date])
        ->select('tenant_service_charges.bal as serviceChargeBal','asset_service_charges.price as total','asset_service_charges.balance as asc_bal','asset_service_charges.payment_status as paymentStatus','service_charges.name as serviceCharge','assets.description as assetName',DB::raw('CONCAT(ll.designation, " ", ll.firstname, " ", ll.lastname) as landlordDetail'),DB::raw('CONCAT(tenants.designation, " ", tenants.firstname, " ", tenants.lastname) as tenantDetail'))
         ->get();
  return view('new.admin.reports.service_charge_report',compact('service_charges','start_date','end_date','selected_tenant','selected_payment','apartment_type','tenant_name'));
}elseif(isset($start_date) !=='' && isset($end_date) !=='' && $data['payment'] == 'Partly'){
      $selected_payment = $data['payment'];
$service_charges = TenantServiceCharge::join('asset_service_charges', 'asset_service_charges.id', '=', 'tenant_service_charges.asc_id')
        ->join('tenants','tenants.id','=','tenant_service_charges.tenant_id')
        ->join('service_charges','service_charges.id','=','tenant_service_charges.service_chargeId')
        ->join('assets','assets.id','=','asset_service_charges.asset_id')
        ->join('landlords as ll','ll.id','=','assets.landlord_id')
        ->where('tenant_service_charges.user_id', getOwnerUserID())
        ->where('asset_service_charges.payment_status', 'Partly Paid')
        ->whereBetween('asset_service_charges.dueDate',[$start_date,$end_date])
        ->select('tenant_service_charges.bal as serviceChargeBal','asset_service_charges.price as total','asset_service_charges.balance as asc_bal','asset_service_charges.payment_status as paymentStatus','service_charges.name as serviceCharge','assets.description as assetName',DB::raw('CONCAT(ll.designation, " ", ll.firstname, " ", ll.lastname) as landlordDetail'),DB::raw('CONCAT(tenants.designation, " ", tenants.firstname, " ", tenants.lastname) as tenantDetail'))
         ->get();
  return view('new.admin.reports.service_charge_report',compact('service_charges','start_date','end_date','selected_tenant','selected_payment','apartment_type','tenant_name'));
}elseif(isset($start_date) !=='' && isset($end_date) !=='' && $data['payment'] == 'Pending'){
      $selected_payment = $data['payment'];
$service_charges = TenantServiceCharge::join('asset_service_charges', 'asset_service_charges.id', '=', 'tenant_service_charges.asc_id')
        ->join('tenants','tenants.id','=','tenant_service_charges.tenant_id')
        ->join('service_charges','service_charges.id','=','tenant_service_charges.service_chargeId')
        ->join('assets','assets.id','=','asset_service_charges.asset_id')
        ->join('landlords as ll','ll.id','=','assets.landlord_id')
        ->where('tenant_service_charges.user_id', getOwnerUserID())
        ->where('asset_service_charges.payment_status', 'Pending')
        ->whereBetween('asset_service_charges.dueDate',[$start_date,$end_date])
        ->select('tenant_service_charges.bal as serviceChargeBal','asset_service_charges.price as total','asset_service_charges.balance as asc_bal','asset_service_charges.payment_status as paymentStatus','service_charges.name as serviceCharge','assets.description as assetName',DB::raw('CONCAT(ll.designation, " ", ll.firstname, " ", ll.lastname) as landlordDetail'),DB::raw('CONCAT(tenants.designation, " ", tenants.firstname, " ", tenants.lastname) as tenantDetail'))
         ->get();
  return view('new.admin.reports.service_charge_report',compact('service_charges','start_date','end_date','selected_tenant','selected_payment','apartment_type','tenant_name'));
}
return view('new.admin.reports.service_charge_report',compact('start_date','end_date','selected_tenant','selected_payment','apartment_type','tenant_name'));
}
   

   public function showPortfolioReport(Request $request)
    {
      $start_date = '';
      $end_date = '';
      $country = DB::table('countries')->where('id','3')->select('id','name')->first();
      $state = DB::table('states')->where('id','112')->select('id','name')->first();
      $city =  DB::table('cities')->where('id','6089 ')->select('id','name')->first();
      $propertyUsed = '';
      $propertyType = '';
        return view('new.admin.reports.general_portfolio_report',compact('start_date','end_date','country','state','city','propertyType','propertyUsed'));

    }

    public function generalPortfolioReport(Request $request)
    {
        $data = $request->all();
        //dd($request->all());

        $property_used='';
        $properties_used=['Residential','Commercial','All'];
        foreach ($properties_used as $key => $prop) {
          if($prop == $data['property_used']){
            $property_used = $prop;
          }
        }

    $start_date = Carbon::parse(formatDate($data['startDate'], 'd/m/Y', 'Y-m-d'));
    $end_date   = Carbon::parse(formatDate($data['dueDate'], 'd/m/Y', 'Y-m-d'));

       if($data['property_type'] =='All' && $property_used =='All'){
  $portfolio_reportDetails = Portfolio::generalPortfolioForAllPropertyTypeAndAllPropertyUsed($data,$start_date,$end_date);
                    
                  $min_amt = Portfolio::portfolioData($portfolio_reportDetails)['min_amt'];
                   $max_amt = Portfolio::portfolioData($portfolio_reportDetails)['max_amt'];
                   $averageAmt = Portfolio::portfolioData($portfolio_reportDetails)['averageAmt'];
                   $property_count = Portfolio::portfolioData($portfolio_reportDetails)['property_count'];
                   $rents_count = Portfolio::portfolioData($portfolio_reportDetails)['rents_count'];
                   $occupancyRate = Portfolio::portfolioData($portfolio_reportDetails)['occupancyRate'];
                   $amt_sum = Portfolio::portfolioData($portfolio_reportDetails)['amt_sum'];
                   $total_fees = Portfolio::portfolioData($portfolio_reportDetails)['total_fees'];
                   $total_paid_rent = Portfolio::portfolioData($portfolio_reportDetails)['total_paid_rent'];
                   $performance = Portfolio::portfolioData($portfolio_reportDetails)['performance'];


     $start_date = $start_date;
      $end_date = $end_date;
      $country = DB::table('countries')->where('id',$data['country'])->select('id','name')->first();
      $state = DB::table('states')->where('id',$data['state'])->select('id','name')->first();
      $city =  DB::table('cities')->where('id',$data['city'])->select('id','name')->first();
      $propertyUsed = $property_used;
      $propertyType = $data['property_type'];
        return view('new.admin.reports.general_portfolio_report',compact('portfolio_reportDetails','start_date','end_date','country','state','city','propertyType','propertyUsed','min_amt','max_amt','averageAmt','property_count','rents_count','occupancyRate','amt_sum','total_fees','total_paid_rent','performance'));

                    }else if($data['property_type'] =='All' && $property_used !='All'){
                $portfolio_reportDetails = Portfolio::generalPortfolioForAllPropertyType($data,$start_date,$end_date,$property_used);

                  $min_amt = Portfolio::portfolioData($portfolio_reportDetails)['min_amt'];
                   $max_amt = Portfolio::portfolioData($portfolio_reportDetails)['max_amt'];
                   $averageAmt = Portfolio::portfolioData($portfolio_reportDetails)['averageAmt'];
                   $property_count = Portfolio::portfolioData($portfolio_reportDetails)['property_count'];
                   $rents_count = Portfolio::portfolioData($portfolio_reportDetails)['rents_count'];
                   $occupancyRate = Portfolio::portfolioData($portfolio_reportDetails)['occupancyRate'];
                   $amt_sum = Portfolio::portfolioData($portfolio_reportDetails)['amt_sum'];
                   $total_fees = Portfolio::portfolioData($portfolio_reportDetails)['total_fees'];
                   $total_paid_rent = Portfolio::portfolioData($portfolio_reportDetails)['total_paid_rent'];
                   $performance = Portfolio::portfolioData($portfolio_reportDetails)['performance'];

      $start_date = $start_date;
      $end_date = $end_date;
      $country = DB::table('countries')->where('id',$data['country'])->select('id','name')->first();
      $state = DB::table('states')->where('id',$data['state'])->select('id','name')->first();
      $city =  DB::table('cities')->where('id',$data['city'])->select('id','name')->first();
      $propertyUsed = $property_used;
      $propertyType = $data['property_type'];
        return view('new.admin.reports.general_portfolio_report',compact('portfolio_reportDetails','start_date','end_date','country','state','city','propertyType','propertyUsed','min_amt','max_amt','averageAmt','property_count','rents_count','occupancyRate','amt_sum','total_fees','total_paid_rent','performance'));

                    }else if($data['property_type'] !='All' && $property_used =='All'){
                  $portfolio_reportDetails = Portfolio::generalPortfolioForAllPropertyUsed($data,$start_date,$end_date);
        
                   $min_amt = Portfolio::portfolioData($portfolio_reportDetails)['min_amt'];
                   $max_amt = Portfolio::portfolioData($portfolio_reportDetails)['max_amt'];
                   $averageAmt = Portfolio::portfolioData($portfolio_reportDetails)['averageAmt'];
                   $property_count = Portfolio::portfolioData($portfolio_reportDetails)['property_count'];
                   $rents_count = Portfolio::portfolioData($portfolio_reportDetails)['rents_count'];
                   $occupancyRate = Portfolio::portfolioData($portfolio_reportDetails)['occupancyRate'];
                   $amt_sum = Portfolio::portfolioData($portfolio_reportDetails)['amt_sum'];
                   $total_fees = Portfolio::portfolioData($portfolio_reportDetails)['total_fees'];
                   $total_paid_rent = Portfolio::portfolioData($portfolio_reportDetails)['total_paid_rent'];
                   $performance = Portfolio::portfolioData($portfolio_reportDetails)['performance'];


      $start_date = $start_date;
      $end_date = $end_date;
      $country = DB::table('countries')->where('id',$data['country'])->select('id','name')->first();
      $state = DB::table('states')->where('id',$data['state'])->select('id','name')->first();
      $city =  DB::table('cities')->where('id',$data['city'])->select('id','name')->first();
      $propertyUsed = $property_used;
      $propertyType = $data['property_type'];
        return view('new.admin.reports.general_portfolio_report',compact('portfolio_reportDetails','start_date','end_date','country','state','city','propertyType','propertyUsed','min_amt','max_amt','averageAmt','property_count','rents_count','occupancyRate','amt_sum','total_fees','total_paid_rent','performance'));

                    }else{


  $portfolio_reportDetails = Portfolio::generalPortfolioDefault($data,$start_date,$end_date,$property_used);

                   $min_amt = Portfolio::portfolioData($portfolio_reportDetails)['min_amt'];
                   $max_amt = Portfolio::portfolioData($portfolio_reportDetails)['max_amt'];
                   $averageAmt = Portfolio::portfolioData($portfolio_reportDetails)['averageAmt'];
                   $property_count = Portfolio::portfolioData($portfolio_reportDetails)['property_count'];
                   $rents_count = Portfolio::portfolioData($portfolio_reportDetails)['rents_count'];
                   $occupancyRate = Portfolio::portfolioData($portfolio_reportDetails)['occupancyRate'];
                   $amt_sum = Portfolio::portfolioData($portfolio_reportDetails)['amt_sum'];
                   $total_fees = Portfolio::portfolioData($portfolio_reportDetails)['total_fees'];
                   $total_paid_rent = Portfolio::portfolioData($portfolio_reportDetails)['total_paid_rent'];
                   $performance = Portfolio::portfolioData($portfolio_reportDetails)['performance'];

      $start_date = $start_date;
      $end_date = $end_date;
      $country = DB::table('countries')->where('id',$data['country'])->select('id','name')->first();
      $state = DB::table('states')->where('id',$data['state'])->select('id','name')->first();
      $city =  DB::table('cities')->where('id',$data['city'])->select('id','name')->first();
      $propertyUsed = $property_used;
      $propertyType = $data['property_type'];
        return view('new.admin.reports.general_portfolio_report',compact('portfolio_reportDetails','start_date','end_date','country','state','city','propertyType','propertyUsed','min_amt','max_amt','averageAmt','property_count','rents_count','occupancyRate','amt_sum','total_fees','total_paid_rent','performance'));
                    }

    }

   public function showMyPortfolioReport(Request $request)
    {
      $start_date = '';
      $end_date = '';
      $country = DB::table('countries')->where('id','3')->select('id','name')->first();
      $state = DB::table('states')->where('id','112')->select('id','name')->first();
      $city =  DB::table('cities')->where('id','6089 ')->select('id','name')->first();
      $propertyUsed = '';
      $propertyType = '';
        return view('new.admin.reports.my_portfolio_report',compact('start_date','end_date','country','state','city','propertyType','propertyUsed'));

    }


    public function myPortfolioReport(Request $request)
    {
        $data = $request->all();
        //dd($request->all());

        $property_used='';
        $properties_used=['Residential','Commercial','All'];
        foreach ($properties_used as $key => $prop) {
          if($prop == $data['property_used']){
            $property_used = $prop;
          }
        }

    $start_date = Carbon::parse(formatDate($data['startDate'], 'd/m/Y', 'Y-m-d'));
    $end_date   = Carbon::parse(formatDate($data['dueDate'], 'd/m/Y', 'Y-m-d'));

       if($data['property_type'] =='All' && $property_used =='All'){
                       $portfolio_reportDetails = TenantRent::join('assets','assets.uuid','=','tenant_rents.asset_uuid')
                    ->join('units','units.uuid','=','tenant_rents.unit_uuid')
                    ->join('property_types as pt','pt.id','=','units.property_type_id')
                    ->whereBetween('tenant_rents.startDate',[$start_date,$end_date])
                    ->where('assets.country_id',$data['country'])
                    ->where('assets.state_id',$data['state'])
                    ->where('assets.city_id',$data['city'])
                    ->where('tenant_rents.user_id',getOwnerUserID())
                    ->select('tenant_rents.*','tenant_rents.amount as rent_real_amt','units.*','units.uuid as unitID','pt.*','units.rent_commission as rentCommission','tenant_rents.id as rental_id')
                    ->get();
                    
                    $min_amt = \App\Report_objects\Portfolio::portfolioData($portfolio_reportDetails)['min_amt'];
                   $max_amt = \App\Report_objects\Portfolio::portfolioData($portfolio_reportDetails)['max_amt'];
                   $averageAmt = \App\Report_objects\Portfolio::portfolioData($portfolio_reportDetails)['averageAmt'];
                   $property_count = \App\Report_objects\Portfolio::portfolioData($portfolio_reportDetails)['property_count'];
                   $rents_count = \App\Report_objects\Portfolio::portfolioData($portfolio_reportDetails)['rents_count'];
                   $occupancyRate = \App\Report_objects\Portfolio::portfolioData($portfolio_reportDetails)['occupancyRate'];
                   $amt_sum = \App\Report_objects\Portfolio::portfolioData($portfolio_reportDetails)['amt_sum'];
                   $total_fees = \App\Report_objects\Portfolio::portfolioData($portfolio_reportDetails)['total_fees'];
                   $total_paid_rent = \App\Report_objects\Portfolio::portfolioData($portfolio_reportDetails)['total_paid_rent'];
                   $performance = \App\Report_objects\Portfolio::portfolioData($portfolio_reportDetails)['performance'];

                    //general portfolio data
  $general_portfolio_reportDetails = Portfolio::generalPortfolioForAllPropertyTypeAndAllPropertyUsed($data,$start_date,$end_date);

                    $gen_portfolio_min_amt = Portfolio::portfolioData($general_portfolio_reportDetails)['min_amt'];
                   $gen_portfolio_max_amt = Portfolio::portfolioData($general_portfolio_reportDetails)['max_amt'];
                   $gen_portfolio_averageAmt = Portfolio::portfolioData($general_portfolio_reportDetails)['averageAmt'];
                   $gen_portfolio_property_count = Portfolio::portfolioData($general_portfolio_reportDetails)['property_count'];
                   $gen_portfolio_rents_count = Portfolio::portfolioData($general_portfolio_reportDetails)['rents_count'];
                   $gen_portfolio_occupancyRate = Portfolio::portfolioData($general_portfolio_reportDetails)['occupancyRate'];
                   $gen_portfolio_amt_sum = Portfolio::portfolioData($general_portfolio_reportDetails)['amt_sum'];
                   $gen_portfolio_total_fees = Portfolio::portfolioData($general_portfolio_reportDetails)['total_fees'];
                   $gen_portfolio_total_paid_rent = Portfolio::portfolioData($general_portfolio_reportDetails)['total_paid_rent'];
                   $gen_portfolio_performance = Portfolio::portfolioData($general_portfolio_reportDetails)['performance'];

      $start_date = $start_date;
      $end_date = $end_date;
      $country = DB::table('countries')->where('id',$data['country'])->select('id','name')->first();
      $state = DB::table('states')->where('id',$data['state'])->select('id','name')->first();
      $city =  DB::table('cities')->where('id',$data['city'])->select('id','name')->first();
      $propertyUsed = $property_used;
      $propertyType = $data['property_type'];
        return view('new.admin.reports.my_portfolio_report',compact('portfolio_reportDetails','start_date','end_date','country','state','city','propertyType','propertyUsed','min_amt','max_amt','averageAmt','property_count','rents_count','occupancyRate','amt_sum','total_fees','performance','total_paid_rent','gen_portfolio_min_amt','gen_portfolio_max_amt','gen_portfolio_averageAmt','gen_portfolio_property_count','gen_portfolio_rents_count','gen_portfolio_occupancyRate','gen_portfolio_amt_sum','gen_portfolio_total_fees','gen_portfolio_total_paid_rent','gen_portfolio_performance'));

                    }else if($data['property_type'] =='All' && $property_used !='All'){
                  $portfolio_reportDetails = TenantRent::join('assets','assets.uuid','=','tenant_rents.asset_uuid')
                    ->join('units','units.uuid','=','tenant_rents.unit_uuid')
                    ->join('property_types as pt','pt.id','=','units.property_type_id')
                    ->whereBetween('tenant_rents.startDate',[$start_date,$end_date])
                    ->where('assets.country_id',$data['country'])
                    ->where('units.apartment_type',$property_used)
                    ->where('assets.state_id',$data['state'])
                    ->where('assets.city_id',$data['city'])
                    ->where('tenant_rents.user_id',getOwnerUserID())
                    ->select('tenant_rents.*','units.*','units.uuid as unitID','pt.*','units.rent_commission as rentCommission','tenant_rents.id as rental_id')
                    ->get();
         
                   $min_amt = \App\Report_objects\Portfolio::portfolioData($portfolio_reportDetails)['min_amt'];
                   $max_amt = \App\Report_objects\Portfolio::portfolioData($portfolio_reportDetails)['max_amt'];
                   $averageAmt = \App\Report_objects\Portfolio::portfolioData($portfolio_reportDetails)['averageAmt'];
                   $property_count = \App\Report_objects\Portfolio::portfolioData($portfolio_reportDetails)['property_count'];
                   $rents_count = \App\Report_objects\Portfolio::portfolioData($portfolio_reportDetails)['rents_count'];
                   $occupancyRate = \App\Report_objects\Portfolio::portfolioData($portfolio_reportDetails)['occupancyRate'];
                   $amt_sum = \App\Report_objects\Portfolio::portfolioData($portfolio_reportDetails)['amt_sum'];
                   $total_fees = \App\Report_objects\Portfolio::portfolioData($portfolio_reportDetails)['total_fees'];
                   $total_paid_rent = \App\Report_objects\Portfolio::portfolioData($portfolio_reportDetails)['total_paid_rent'];
                   $performance = \App\Report_objects\Portfolio::portfolioData($portfolio_reportDetails)['performance'];

//general portfolio data
  $general_portfolio_reportDetails =Portfolio::generalPortfolioForAllPropertyType($data,$start_date,$end_date,$property_used);
                    $gen_portfolio_min_amt = Portfolio::portfolioData($general_portfolio_reportDetails)['min_amt'];
                   $gen_portfolio_max_amt = Portfolio::portfolioData($general_portfolio_reportDetails)['max_amt'];
                   $gen_portfolio_averageAmt = Portfolio::portfolioData($general_portfolio_reportDetails)['averageAmt'];
                   $gen_portfolio_property_count = Portfolio::portfolioData($general_portfolio_reportDetails)['property_count'];
                   $gen_portfolio_rents_count = Portfolio::portfolioData($general_portfolio_reportDetails)['rents_count'];
                   $gen_portfolio_occupancyRate = Portfolio::portfolioData($general_portfolio_reportDetails)['occupancyRate'];
                   $gen_portfolio_amt_sum = Portfolio::portfolioData($general_portfolio_reportDetails)['amt_sum'];
                   $gen_portfolio_total_fees = Portfolio::portfolioData($general_portfolio_reportDetails)['total_fees'];
                   $gen_portfolio_total_paid_rent = Portfolio::portfolioData($general_portfolio_reportDetails)['total_paid_rent'];
                   $gen_portfolio_performance = Portfolio::portfolioData($general_portfolio_reportDetails)['performance'];
      $start_date = $start_date;
      $end_date = $end_date;
      $country = DB::table('countries')->where('id',$data['country'])->select('id','name')->first();
      $state = DB::table('states')->where('id',$data['state'])->select('id','name')->first();
      $city =  DB::table('cities')->where('id',$data['city'])->select('id','name')->first();
      $propertyUsed = $property_used;
      $propertyType = $data['property_type'];
        return view('new.admin.reports.my_portfolio_report',compact('portfolio_reportDetails','start_date','end_date','country','state','city','propertyType','propertyUsed','min_amt','max_amt','averageAmt','property_count','rents_count','occupancyRate','amt_sum','total_fees','performance','total_paid_rent','gen_portfolio_min_amt','gen_portfolio_max_amt','gen_portfolio_averageAmt','gen_portfolio_property_count','gen_portfolio_rents_count','gen_portfolio_occupancyRate','gen_portfolio_amt_sum','gen_portfolio_total_fees','gen_portfolio_total_paid_rent','gen_portfolio_performance'));

                    }else if($data['property_type'] !='All' && $property_used =='All'){
                  $portfolio_reportDetails = TenantRent::join('assets','assets.uuid','=','tenant_rents.asset_uuid')
                    ->join('units','units.uuid','=','tenant_rents.unit_uuid')
                    ->join('property_types as pt','pt.id','=','units.property_type_id')
                    ->whereBetween('tenant_rents.startDate',[$start_date,$end_date])
                    ->where('assets.country_id',$data['country'])
                    ->where('units.property_type_id',$data['property_type'])
                    ->where('assets.state_id',$data['state'])
                    ->where('assets.city_id',$data['city'])
                    ->where('tenant_rents.user_id',getOwnerUserID())
                    ->select('tenant_rents.*','units.*','units.uuid as unitID','pt.*','units.rent_commission as rentCommission','tenant_rents.id as rental_id')
                    ->get();
        
                     $min_amt = \App\Report_objects\Portfolio::portfolioData($portfolio_reportDetails)['min_amt'];
                   $max_amt = \App\Report_objects\Portfolio::portfolioData($portfolio_reportDetails)['max_amt'];
                   $averageAmt = \App\Report_objects\Portfolio::portfolioData($portfolio_reportDetails)['averageAmt'];
                   $property_count = \App\Report_objects\Portfolio::portfolioData($portfolio_reportDetails)['property_count'];
                   $rents_count = \App\Report_objects\Portfolio::portfolioData($portfolio_reportDetails)['rents_count'];
                   $occupancyRate = \App\Report_objects\Portfolio::portfolioData($portfolio_reportDetails)['occupancyRate'];
                   $amt_sum = \App\Report_objects\Portfolio::portfolioData($portfolio_reportDetails)['amt_sum'];
                   $total_fees = \App\Report_objects\Portfolio::portfolioData($portfolio_reportDetails)['total_fees'];
                   $total_paid_rent = \App\Report_objects\Portfolio::portfolioData($portfolio_reportDetails)['total_paid_rent'];
                   $performance = \App\Report_objects\Portfolio::portfolioData($portfolio_reportDetails)['performance'];

                   //general portfolio data
  $general_portfolio_reportDetails = Portfolio::generalPortfolioForAllPropertyUsed($data,$start_date,$end_date);
                    $gen_portfolio_min_amt = Portfolio::portfolioData($general_portfolio_reportDetails)['min_amt'];
                   $gen_portfolio_max_amt = Portfolio::portfolioData($general_portfolio_reportDetails)['max_amt'];
                   $gen_portfolio_averageAmt = Portfolio::portfolioData($general_portfolio_reportDetails)['averageAmt'];
                   $gen_portfolio_property_count = Portfolio::portfolioData($general_portfolio_reportDetails)['property_count'];
                   $gen_portfolio_rents_count = Portfolio::portfolioData($general_portfolio_reportDetails)['rents_count'];
                   $gen_portfolio_occupancyRate = Portfolio::portfolioData($general_portfolio_reportDetails)['occupancyRate'];
                   $gen_portfolio_amt_sum = Portfolio::portfolioData($general_portfolio_reportDetails)['amt_sum'];
                   $gen_portfolio_total_fees = Portfolio::portfolioData($general_portfolio_reportDetails)['total_fees'];
                   $gen_portfolio_total_paid_rent = Portfolio::portfolioData($general_portfolio_reportDetails)['total_paid_rent'];
                   $gen_portfolio_performance = Portfolio::portfolioData($general_portfolio_reportDetails)['performance'];
       $start_date = $start_date;
      $end_date = $end_date;
      $country = DB::table('countries')->where('id',$data['country'])->select('id','name')->first();
      $state = DB::table('states')->where('id',$data['state'])->select('id','name')->first();
      $city =  DB::table('cities')->where('id',$data['city'])->select('id','name')->first();
      $propertyUsed = $property_used;
      $propertyType = $data['property_type'];
        return view('new.admin.reports.my_portfolio_report',compact('portfolio_reportDetails','start_date','end_date','country','state','city','propertyType','propertyUsed','min_amt','max_amt','averageAmt','property_count','rents_count','occupancyRate','amt_sum','total_fees','performance','total_paid_rent','gen_portfolio_min_amt','gen_portfolio_max_amt','gen_portfolio_averageAmt','gen_portfolio_property_count','gen_portfolio_rents_count','gen_portfolio_occupancyRate','gen_portfolio_amt_sum','gen_portfolio_total_fees','gen_portfolio_total_paid_rent','gen_portfolio_performance'));

                    }else{

          $portfolio_reportDetails = TenantRent::join('assets','assets.uuid','=','tenant_rents.asset_uuid')
                    ->join('units','units.uuid','=','tenant_rents.unit_uuid')
                    ->join('property_types as pt','pt.id','=','units.property_type_id')
                    ->whereBetween('tenant_rents.startDate',[$start_date,$end_date])
                    ->where('units.apartment_type',$property_used)
                    ->where('units.property_type_id',$data['property_type'])
                    ->where('assets.country_id',$data['country'])
                    ->where('assets.state_id',$data['state'])
                    ->where('assets.city_id',$data['city'])
                    ->where('tenant_rents.user_id',getOwnerUserID())
                    ->select('tenant_rents.*','units.*','units.uuid as unitID','pt.*','tenant_rents.amount as rent_real_amt','tenant_rents.status as rent_payment_status','units.rent_commission as rentCommission','tenant_rents.id as rental_id')
                    ->get();

                   $min_amt = \App\Report_objects\Portfolio::portfolioData($portfolio_reportDetails)['min_amt'];
                   $max_amt = \App\Report_objects\Portfolio::portfolioData($portfolio_reportDetails)['max_amt'];
                   $averageAmt = \App\Report_objects\Portfolio::portfolioData($portfolio_reportDetails)['averageAmt'];
                   $property_count = \App\Report_objects\Portfolio::portfolioData($portfolio_reportDetails)['property_count'];
                   $rents_count = \App\Report_objects\Portfolio::portfolioData($portfolio_reportDetails)['rents_count'];
                   $occupancyRate = \App\Report_objects\Portfolio::portfolioData($portfolio_reportDetails)['occupancyRate'];
                   $amt_sum = \App\Report_objects\Portfolio::portfolioData($portfolio_reportDetails)['amt_sum'];
                   $total_fees = \App\Report_objects\Portfolio::portfolioData($portfolio_reportDetails)['total_fees'];
                   $total_paid_rent = \App\Report_objects\Portfolio::portfolioData($portfolio_reportDetails)['total_paid_rent'];
                   $performance = \App\Report_objects\Portfolio::portfolioData($portfolio_reportDetails)['performance'];

                   //general portfolio data
                    $general_portfolio_reportDetails = Portfolio::generalPortfolioForAllPropertyUsed($data,$start_date,$end_date);

                    $gen_portfolio_min_amt = Portfolio::portfolioData($general_portfolio_reportDetails)['min_amt'];
                   $gen_portfolio_max_amt = Portfolio::portfolioData($general_portfolio_reportDetails)['max_amt'];
                   $gen_portfolio_averageAmt = Portfolio::portfolioData($general_portfolio_reportDetails)['averageAmt'];
                   $gen_portfolio_property_count = Portfolio::portfolioData($general_portfolio_reportDetails)['property_count'];
                   $gen_portfolio_rents_count = Portfolio::portfolioData($general_portfolio_reportDetails)['rents_count'];
                   $gen_portfolio_occupancyRate = Portfolio::portfolioData($general_portfolio_reportDetails)['occupancyRate'];
                   $gen_portfolio_amt_sum = Portfolio::portfolioData($general_portfolio_reportDetails)['amt_sum'];
                   $gen_portfolio_total_fees = Portfolio::portfolioData($general_portfolio_reportDetails)['total_fees'];
                   $gen_portfolio_total_paid_rent = Portfolio::portfolioData($general_portfolio_reportDetails)['total_paid_rent'];
                   $gen_portfolio_performance = Portfolio::portfolioData($general_portfolio_reportDetails)['performance'];


       $start_date = $start_date;
      $end_date = $end_date;
      $country = DB::table('countries')->where('id',$data['country'])->select('id','name')->first();
      $state = DB::table('states')->where('id',$data['state'])->select('id','name')->first();
      $city =  DB::table('cities')->where('id',$data['city'])->select('id','name')->first();
      $propertyUsed = $property_used;
      $propertyType = $data['property_type'];
        return view('new.admin.reports.my_portfolio_report',compact('portfolio_reportDetails','start_date','end_date','country','state','city','propertyType','propertyUsed','min_amt','max_amt','averageAmt','property_count','rents_count','occupancyRate','amt_sum','total_fees','total_paid_rent','performance','gen_portfolio_min_amt','gen_portfolio_max_amt','gen_portfolio_averageAmt','gen_portfolio_property_count','gen_portfolio_rents_count','gen_portfolio_occupancyRate','gen_portfolio_amt_sum','gen_portfolio_total_fees','gen_portfolio_total_paid_rent','gen_portfolio_performance'));
                    }

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
