<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPreviousRentalIdToTenantRents extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tenant_rents', function (Blueprint $table) {
             $table->integer('previous_rental_id')->after('user_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tenant_rents', function (Blueprint $table) {
            $table->integer('previous_rental_id');
        });
    }
}
