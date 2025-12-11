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
        DB::statement("ALTER TABLE walk_ins ADD COLUMN IF NOT EXISTS bank_transfer VARCHAR(255) NULL AFTER payment_method");
        DB::statement("ALTER TABLE walk_ins ADD COLUMN IF NOT EXISTS bank_transfer_other VARCHAR(255) NULL AFTER bank_transfer");
        DB::statement("ALTER TABLE walk_ins ADD COLUMN IF NOT EXISTS reference_number VARCHAR(255) NULL AFTER bank_transfer_other");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("ALTER TABLE walk_ins DROP COLUMN IF EXISTS bank_transfer");
        DB::statement("ALTER TABLE walk_ins DROP COLUMN IF EXISTS bank_transfer_other");
        DB::statement("ALTER TABLE walk_ins DROP COLUMN IF EXISTS reference_number");
    }
};
