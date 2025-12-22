<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Increase decimal precision for premium and commission columns
        DB::statement('ALTER TABLE `commissions` MODIFY `gross_premium` DECIMAL(15, 2)');
        DB::statement('ALTER TABLE `commissions` MODIFY `net_premium` DECIMAL(15, 2)');
        DB::statement('ALTER TABLE `commissions` MODIFY `commission_amount` DECIMAL(15, 2)');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement('ALTER TABLE `commissions` MODIFY `gross_premium` DECIMAL(10, 2)');
        DB::statement('ALTER TABLE `commissions` MODIFY `net_premium` DECIMAL(10, 2)');
        DB::statement('ALTER TABLE `commissions` MODIFY `commission_amount` DECIMAL(10, 2)');
    }
};
