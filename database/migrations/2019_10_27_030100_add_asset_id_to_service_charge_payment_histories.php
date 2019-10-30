<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddAssetIdToServiceChargePaymentHistories extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('service_charge_payment_histories', function (Blueprint $table) {
             $table->integer('asset_id')->after('tenant')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('service_charge_payment_histories', function (Blueprint $table) {
            $table->integer('asset_id');
        });
    }
}
