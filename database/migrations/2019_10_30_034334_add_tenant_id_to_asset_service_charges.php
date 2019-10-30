<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTenantIdToAssetServiceCharges extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('asset_service_charges', function (Blueprint $table) {


            if (Schema::hasColumn('asset_service_charges', 'tenant_id'))
            {
            Schema::table('asset_service_charges', function (Blueprint $table)
            {
               $table->dropColumn('tenant_id');
            });
          }
             $table->string('tenant_id')->after('updated_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('asset_service_charges', function (Blueprint $table) {
             $table->string('tenant_id');
        });
    }
}
