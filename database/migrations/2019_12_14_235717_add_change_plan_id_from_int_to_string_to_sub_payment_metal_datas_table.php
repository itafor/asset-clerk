<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddChangePlanIdFromIntToStringToSubPaymentMetalDatasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sub_payment_metal_datas', function (Blueprint $table) {
            if (Schema::hasColumn('sub_payment_metal_datas', 'plan_id'))
            {
            Schema::table('sub_payment_metal_datas', function (Blueprint $table)
            {
               $table->dropColumn('plan_id');
            });
        }
               
               $table->string('plan_id')->after('transaction_uuid')->nullable();
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
            $table->string('plan_id');
        });
    }
}
