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
        // Make client_id nullable on policies table. Use raw SQL to avoid requiring doctrine/dbal.
        DB::statement('ALTER TABLE `policies` MODIFY `client_id` BIGINT UNSIGNED NULL');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revert client_id to not null. If there are NULLs this may fail; user should ensure values exist.
        DB::statement('ALTER TABLE `policies` MODIFY `client_id` BIGINT UNSIGNED NOT NULL');
    }
};
