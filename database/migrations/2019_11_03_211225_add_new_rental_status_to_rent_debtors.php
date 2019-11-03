<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddNewRentalStatusToRentDebtors extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('rent_debtors', function (Blueprint $table) {
             $table->string('new_rental_status')->after('user_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('rent_debtors', function (Blueprint $table) {
            $table->string('new_rental_status');
        });
    }
}
