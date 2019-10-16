<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateServiceChargePaymentHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('service_charge_payment_histories', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->integer('tenant');
            $table->integer('service_charge');
            $table->integer('actualAmount');
            $table->integer('amountPaid');
            $table->integer('balance');
            $table->string('property');
            $table->string('payment_mode');
            $table->date('payment_date');
            $table->string('durationPaidFor');
            $table->string('description');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('service_charge_payment_histories');
    }
}
