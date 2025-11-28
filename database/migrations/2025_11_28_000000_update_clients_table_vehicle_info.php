<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateClientsTableVehicleInfo extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('clients', function (Blueprint $table) {
            // Add new columns
            $table->string('tin')->nullable()->after('phone');
            $table->string('make_model')->nullable()->after('tin');
            $table->string('plate_no')->nullable()->after('make_model');
            $table->integer('model_year')->nullable()->after('plate_no');
            $table->string('color')->nullable()->after('model_year');
            
            // Drop old columns
            $table->dropColumn(['birthDate', 'occupation']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('clients', function (Blueprint $table) {
            // Add back the old columns
            $table->date('birthDate')->nullable();
            $table->string('occupation')->nullable();
            
            // Drop new columns
            $table->dropColumn(['tin', 'make_model', 'plate_no', 'model_year', 'color']);
        });
    }
}
