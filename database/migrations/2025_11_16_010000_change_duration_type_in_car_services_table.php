<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('car_services')) {
            try {
                DB::statement("ALTER TABLE `car_services` MODIFY `duration` VARCHAR(255) NULL;");
            } catch (\Exception $e) {
                // If ALTER fails, bubble up for visibility
                throw $e;
            }
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (Schema::hasTable('car_services')) {
            try {
                DB::statement("ALTER TABLE `car_services` MODIFY `duration` INT NULL;");
            } catch (\Exception $e) {
                throw $e;
            }
        }
    }
};
