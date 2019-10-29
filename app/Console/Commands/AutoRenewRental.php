<?php

namespace App\Console\Commands;

use App\Jobs\RentalCreatedEmailJob;
use App\TenantRent;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class AutoRenewRental extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'renew:AutoRenewRental';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Renew rentals that reached due date';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $newRentals = TenantRent::join('rent_dues as rd', 'rd.rent_id', '=', 'tenant_rents.id')
        ->where('rd.status', 'pending')
        ->whereRaw("DATE_ADD(CURDATE(), INTERVAL 3 DAY) = rd.due_date") 
        ->orderBy('tenant_rents.id', 'desc')->select('tenant_rents.*')->get();
        
       //dd($newRentals);

            foreach($newRentals as $rental) {

    $newRentDetails['tenant']    =  $rental['tenant_uuid'];
    $newRentDetails['property']  = $rental['asset_uuid'];
    $newRentDetails['unit']      = $rental['unit_uuid'];
    $newRentDetails['price']     = $rental['price'];
    $newRentDetails['amount']    = $rental['amount'];
    $newRentDetails['startDate'] = Carbon::now()->format('d/m/Y');
    $newRentDetails['due_date'] = Carbon::now()->addYear()->format('d/m/Y');
    $newRentDetails['user_id']    = $rental['user_id'];

            if(!empty($newRentDetails)){

                DB::beginTransaction();
        try {
            $rental = TenantRent::createNew($newRentDetails);

            RentalCreatedEmailJob::dispatch($rental)
            ->delay(now()->addSeconds(5));
                         
            DB::commit();

        } catch (Exception $e) {
            DB::rollback();
            return false;
            }

        }
    }
    }
}
