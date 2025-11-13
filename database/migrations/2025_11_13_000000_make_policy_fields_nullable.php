<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Use raw SQL to alter columns to nullable to avoid requiring doctrine/dbal
        // Drop foreign key if exists (default Laravel fk name: policies_insurance_provider_id_foreign)
        try {
            DB::statement('ALTER TABLE `policies` DROP FOREIGN KEY `policies_insurance_provider_id_foreign`');
        } catch (\Exception $e) {
            // ignore if it doesn't exist
        }

        // Modify insurance_provider_id to be nullable
        DB::statement('ALTER TABLE `policies` MODIFY `insurance_provider_id` BIGINT UNSIGNED NULL');

        // Recreate FK with ON DELETE SET NULL
        try {
            DB::statement('ALTER TABLE `policies` ADD CONSTRAINT `policies_insurance_provider_id_foreign` FOREIGN KEY (`insurance_provider_id`) REFERENCES `insurance_providers`(`id`) ON DELETE SET NULL');
        } catch (\Exception $e) {
            // ignore if adding FK fails
        }

        // Make start_date and end_date nullable
        try {
            DB::statement('ALTER TABLE `policies` MODIFY `start_date` DATE NULL');
            DB::statement('ALTER TABLE `policies` MODIFY `end_date` DATE NULL');
        } catch (\Exception $e) {
            // ignore
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revert changes via raw SQL
        try {
            DB::statement('ALTER TABLE `policies` DROP FOREIGN KEY `policies_insurance_provider_id_foreign`');
        } catch (\Exception $e) {
            // ignore
        }

        // Make insurance_provider_id NOT NULL and recreate FK with cascade
        try {
            DB::statement('ALTER TABLE `policies` MODIFY `insurance_provider_id` BIGINT UNSIGNED NOT NULL');
            DB::statement('ALTER TABLE `policies` ADD CONSTRAINT `policies_insurance_provider_id_foreign` FOREIGN KEY (`insurance_provider_id`) REFERENCES `insurance_providers`(`id`) ON DELETE CASCADE');
        } catch (\Exception $e) {
            // ignore
        }

        try {
            DB::statement('ALTER TABLE `policies` MODIFY `start_date` DATE NOT NULL');
            DB::statement('ALTER TABLE `policies` MODIFY `end_date` DATE NOT NULL');
        } catch (\Exception $e) {
            // ignore
        }
    }
};
