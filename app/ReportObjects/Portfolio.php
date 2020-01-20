<?php

namespace App\ReportObjects;

use App\TenantRent;
use App\Unit;
use Illuminate\Support\collection;

class Portfolio 
{

public static function generalPortfolioForAllPropertyTypeAndAllPropertyUsed($data,$start_date,$end_date){
	 $portfolio_reportDetails = TenantRent::join('assets','assets.uuid','=','tenant_rents.asset_uuid')
                    ->join('units','units.uuid','=','tenant_rents.unit_uuid')
                    ->join('property_types as pt','pt.id','=','units.property_type_id')
                    ->whereBetween('tenant_rents.startDate',[$start_date,$end_date])
                    ->where('assets.country_id',$data['country'])
                    ->where('assets.state_id',$data['state'])
                    ->where('assets.city_id',$data['city'])
                    ->select('tenant_rents.*','tenant_rents.amount as rent_real_amt','units.*','units.uuid as unitID','pt.*','units.rent_commission as rentCommission','tenant_rents.id as rental_id')
                    ->get();

                    return $portfolio_reportDetails;
}

public static function generalPortfolioForAllPropertyType($data,$start_date,$end_date,$property_used){

$portfolio_reportDetails = TenantRent::join('assets','assets.uuid','=','tenant_rents.asset_uuid')
                    ->join('units','units.uuid','=','tenant_rents.unit_uuid')
                    ->join('property_types as pt','pt.id','=','units.property_type_id')
                    ->whereBetween('tenant_rents.startDate',[$start_date,$end_date])
                    ->where('assets.country_id',$data['country'])
                    ->where('units.apartment_type',$property_used)
                    ->where('assets.state_id',$data['state'])
                    ->where('assets.city_id',$data['city'])
                    ->select('tenant_rents.*','units.*','units.uuid as unitID','pt.*','units.rent_commission as rentCommission','tenant_rents.id as rental_id')
                    ->get();   

                    return $portfolio_reportDetails;

	}

	public static function generalPortfolioForAllPropertyUsed($data,$start_date,$end_date){

$portfolio_reportDetails = TenantRent::join('assets','assets.uuid','=','tenant_rents.asset_uuid')
                    ->join('units','units.uuid','=','tenant_rents.unit_uuid')
                    ->join('property_types as pt','pt.id','=','units.property_type_id')
                    ->whereBetween('tenant_rents.startDate',[$start_date,$end_date])
                    ->where('assets.country_id',$data['country'])
                    ->where('units.property_type_id',$data['property_type'])
                    ->where('assets.state_id',$data['state'])
                    ->where('assets.city_id',$data['city'])
                    ->select('tenant_rents.*','units.*','units.uuid as unitID','pt.*','units.rent_commission as rentCommission','tenant_rents.id as rental_id')
                    ->get();

                    return $portfolio_reportDetails;

	}

	public static function generalPortfolioDefault($data,$start_date,$end_date,$property_used){

$portfolio_reportDetails = TenantRent::join('assets','assets.uuid','=','tenant_rents.asset_uuid')
                    ->join('units','units.uuid','=','tenant_rents.unit_uuid')
                    ->join('property_types as pt','pt.id','=','units.property_type_id')
                    ->whereBetween('tenant_rents.startDate',[$start_date,$end_date])
                    ->where('units.apartment_type',$property_used)
                    ->where('units.property_type_id',$data['property_type'])
                    ->where('assets.country_id',$data['country'])
                    ->where('assets.state_id',$data['state'])
                    ->where('assets.city_id',$data['city'])
                    ->select('tenant_rents.*','units.*','units.uuid as unitID','pt.*','tenant_rents.amount as rent_real_amt','tenant_rents.status as rent_payment_status','units.rent_commission as rentCommission','tenant_rents.id as rental_id')
                    ->get();

                    return $portfolio_reportDetails;

	}



    public static function average_amt($sum,$count)
    {
        $avg= $sum/$count;
       $final_avg = $avg;
        return $final_avg;
    }

    public static function occupancy_rate($rents_count,$prop_count)
    {
        $occ_rate= ($rents_count/$prop_count) * 100;
       $final_occupancy_rate = round($occ_rate,2);
        return $final_occupancy_rate;
    }

    public static function commission($comm_rate,$rent_amt)
    {
        $comm= ($comm_rate/100) * $rent_amt;
       $final_commission = round($comm,2);
        return $final_commission;
    }

    public static function performance($performance_rate,$occupancyRate)
    {
        $performant= ($performance_rate + $occupancyRate);
       $final_performant= round($performant/2,2);
        return $final_performant;
    }


    public static function portfolioData($reports)
    {
        $standard_amts = [];
                   foreach ($reports as $key => $value) {
                      $standard_amts[] = $value->amount;
                   }

                   $standard_amt_collections=new collection($standard_amts);
                        $min_amt = $standard_amt_collections->min();
                        $max_amt = $standard_amt_collections->max();
                        $amt_sum = $standard_amt_collections->sum();
                        $amt_count = $standard_amt_collections->count();
                        $averageAmt=0;
                        if($amt_count !=0){
                        $averageAmt = self::average_amt($amt_sum,$amt_count);
                        }

                        $unit_ids=[];
                        $properties =[];
                        $rents = [];
                        $commissions=[];
                        $paid_rent_collections=[];
                  foreach ($reports as $key => $value) {
                       $unit_ids[]=$value->unitID;
                      $rents[] = $value->rental_id;
                      $commissions[]= self::commission($value->rentCommission,$value->amount);
                      $paid_rent_collections[]=$value->balance == 0 ? $value->amount : 0;
                   }

                   $unit_uuids = array_unique($unit_ids);
                   foreach ($unit_uuids as $key => $uid) {
                    $unit=Unit::where('uuid',$uid)->first();
                    if($unit){
                      $properties[] = $unit->quantity;
                    }
                 }


                   $property_collections=new collection($properties);
                   $rents_collections=new collection($rents);
                   $commission_collections=new collection($commissions);
                   $paid_rents=new collection($paid_rent_collections);

                   $total_paid_rent = $paid_rents->sum();
                   $rents_count = $rents_collections->count();
                   $property_count = $property_collections->sum();
                   $total_fees = $commission_collections->sum();
                   $performance=0;


                    $occupancyRate = 0.0;
                   if($property_count !=0){
                   $occupancyRate = self::occupancy_rate($rents_count,$property_count);
                        }

                   if($property_count !=0 && $rents_count !=0){
                    $performance_rate = round(($total_paid_rent/$amt_sum) * 100,2) ;

                   $performance = self::performance($performance_rate,$occupancyRate);
                        }

                  return [
                      'min_amt'=>$min_amt,
                      'max_amt'=>$max_amt,
                      'averageAmt'=>$averageAmt,
                      'property_count'=>$property_count,
                      'rents_count'=>$rents_count,
                      'occupancyRate'=>$occupancyRate,
                      'amt_sum'=>$amt_sum,
                      'total_fees'=>$total_fees,
                      'total_paid_rent'=>$total_paid_rent,
                      'performance_rate'=>$performance_rate,
                      'performance'=>$performance,
                  ];
    }


}