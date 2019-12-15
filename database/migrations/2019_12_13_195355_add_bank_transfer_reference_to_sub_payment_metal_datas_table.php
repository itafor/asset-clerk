<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddBankTransferReferenceToSubPaymentMetalDatasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sub_payment_metal_datas', function (Blueprint $table) {
            $table->string('bank_transfer_reference')->after('plan_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sub_payment_metal_datas', function (Blueprint $table) {
           $table->string('bank_transfer_reference');
        });
    }
}
