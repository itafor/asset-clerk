<?php
namespace App\ReportObjects;

use App\Jobs\NotifyDueRentJob;
use App\Jobs\NotifyFinalDueRentJob;
use App\TenantRent;
use Illuminate\Support\Facades\DB;


class DueRentNotification
{

	public static function DueRentNotificationAt25Percent()
    {
     $dueRentals = TenantRent::where('renewable', 'no')
     ->whereRaw('TIMESTAMPDIFF(DAY, CURDATE(),tenant_rents.due_date ) = ROUND(ABS(TIMESTAMPDIFF(DAY, tenant_rents.startDate,tenant_rents.due_date ) * (25/100) ),0)')
         ->select('tenant_rents.*', DB::raw('TIMESTAMPDIFF(DAY,CURDATE(),tenant_rents.due_date) AS remaingdays'))
         ->get();
    //dd($dueRentals);

        foreach($dueRentals as $rental) {
        	$defaultRemainingDuration=5;
                 NotifyFinalDueRentJob::dispatch($rental,$defaultRemainingDuration)
            ->delay(now()->addSeconds(5));
            
        }

      $renewableDueRentals = TenantRent::where('renewable', 'yes')
     ->whereRaw('TIMESTAMPDIFF(DAY, CURDATE(),tenant_rents.due_date ) = ROUND(ABS(TIMESTAMPDIFF(DAY, tenant_rents.startDate,tenant_rents.due_date ) * (25/100) ),0)')
         ->select('tenant_rents.*', DB::raw('TIMESTAMPDIFF(DAY,CURDATE(),tenant_rents.due_date) AS remaingdays'))
         ->get();
    //dd($renewableDueRentals);
        foreach($renewableDueRentals as $rental) {
             $renewed_rental = TenantRent::where('previous_rental_id',$rental->id)->first();
             $defaultRemainingDuration=5;
             if($renewed_rental){
                 NotifyDueRentJob::dispatch($rental,$renewed_rental,$defaultRemainingDuration)
            ->delay(now()->addSeconds(5));
             }
            
        }
 }

 	public static function DueRentNotificationAt12Percent()
    {
    	 $dueRentals = TenantRent::where('renewable', 'no')
     ->whereRaw('TIMESTAMPDIFF(DAY, CURDATE(),tenant_rents.due_date ) = ROUND(ABS(TIMESTAMPDIFF(DAY, tenant_rents.startDate,tenant_rents.due_date ) * (12/100) ),0)') 
         ->select('tenant_rents.*', DB::raw('TIMESTAMPDIFF(DAY,CURDATE(),tenant_rents.due_date) AS remaingdays'))
         ->get();
       
       //dd($dueRentals);
        foreach($dueRentals as $rental) {
                 $defaultRemainingDuration=5;
                 NotifyFinalDueRentJob::dispatch($rental,$defaultRemainingDuration)
            ->delay(now()->addSeconds(5));
        }
 

     $renewableDueRentals = TenantRent::where('renewable', 'yes')
     ->whereRaw('TIMESTAMPDIFF(DAY, CURDATE(),tenant_rents.due_date ) = ROUND(ABS(TIMESTAMPDIFF(DAY, tenant_rents.startDate,tenant_rents.due_date ) * (12/100) ),0)') 
         ->select('tenant_rents.*', DB::raw('TIMESTAMPDIFF(DAY,CURDATE(),tenant_rents.due_date) AS remaingdays'))
         ->get();
          
          //dd($renewableDueRentals);
         
        foreach($renewableDueRentals as $rental) {
             $renewed_rental = TenantRent::where('previous_rental_id',$rental->id)->first();
             $defaultRemainingDuration=5;
             if($renewed_rental){
                 NotifyDueRentJob::dispatch($rental,$renewed_rental,$defaultRemainingDuration)
            ->delay(now()->addSeconds(5));
             }
        }
    
 }

 public static function DueRentNotificationAt6Percent()
    {

     $dueRentals = TenantRent::where('renewable', 'no')
     ->whereRaw('TIMESTAMPDIFF(DAY, CURDATE(),tenant_rents.due_date ) = ROUND(ABS(TIMESTAMPDIFF(DAY, tenant_rents.startDate,tenant_rents.due_date ) * (6/100) ),0)') 
         ->select('tenant_rents.*', DB::raw('TIMESTAMPDIFF(DAY,CURDATE(),tenant_rents.due_date) AS remaingdays'))
         ->get();
         //dd($dueRentals);
         
        foreach($dueRentals as $rental) {
                 $defaultRemainingDuration=5;
                 NotifyFinalDueRentJob::dispatch($rental,$defaultRemainingDuration)
            ->delay(now()->addSeconds(5));
    }

     $renewabledueRentals = TenantRent::where('renewable', 'yes')
     ->whereRaw('TIMESTAMPDIFF(DAY, CURDATE(),tenant_rents.due_date ) = ROUND(ABS(TIMESTAMPDIFF(DAY, tenant_rents.startDate,tenant_rents.due_date ) * (6/100) ),0)') 
         ->select('tenant_rents.*', DB::raw('TIMESTAMPDIFF(DAY,CURDATE(),tenant_rents.due_date) AS remaingdays'))
         ->get();
         //dd($renewabledueRentals);
         
        foreach($renewabledueRentals as $rental) {
             $renewed_rental = TenantRent::where('previous_rental_id',$rental->id)->first();
             $defaultRemainingDuration=5;
             if($renewed_rental){
                 NotifyDueRentJob::dispatch($rental,$renewed_rental,$defaultRemainingDuration)
            ->delay(now()->addSeconds(5));
             }
            
        }
      
 }

public static function DueRentNotificationAt0Percent()
    {
       $dueRentals = TenantRent::where('renewable', 'no')
       ->whereRaw('TIMESTAMPDIFF(DAY, CURDATE(),tenant_rents.due_date ) = 0')
         ->select('tenant_rents.*', DB::raw('TIMESTAMPDIFF(DAY,CURDATE(),tenant_rents.due_date) AS remaingdays'))
         ->get();
         //dd($dueRentals);

        foreach($dueRentals as $rental) {
                $defaultRemainingDuration=0;
                 NotifyFinalDueRentJob::dispatch($rental,$defaultRemainingDuration)
            ->delay(now()->addSeconds(5));
            
        }

        $renewabledueRentals = TenantRent::where('renewable', 'yes')
       ->whereRaw('TIMESTAMPDIFF(DAY, CURDATE(),tenant_rents.due_date ) = 0')
         ->select('tenant_rents.*', DB::raw('TIMESTAMPDIFF(DAY,CURDATE(),tenant_rents.due_date) AS remaingdays'))
         ->get();

         //dd($renewabledueRentals);

        foreach($renewabledueRentals as $rental) {
               $renewed_rental = TenantRent::where('previous_rental_id',$rental->id)->first();
             $defaultRemainingDuration=0;
             if($renewed_rental){
                 NotifyDueRentJob::dispatch($rental,$renewed_rental,$defaultRemainingDuration)
            ->delay(now()->addSeconds(5));
             }
            
        }
 }

}