<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddDurationToTenantRents extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tenant_rents', function (Blueprint $table) {
            
            if (Schema::hasColumn('tenant_rents', 'duration'))
            {
            Schema::table('tenant_rents', function (Blueprint $table)
            {
               $table->dropColumn('duration');
            });
        }
               
               $table->string('duration')->after('duration_type')->nullable();

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
             $table->string('duration');
        });
    }
}
