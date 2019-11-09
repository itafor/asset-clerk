<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddAssetServiceChargeIdToServiceChargePaymentHistories extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('service_charge_payment_histories', function (Blueprint $table) {
            $table->integer('asset_service_charge_id')->after('user_id')->nullable();
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
            $table->integer('asset_service_charge_id');
        });
    }
}
