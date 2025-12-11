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
        DB::statement("ALTER TABLE walk_ins ADD COLUMN IF NOT EXISTS premium DECIMAL(10, 2) DEFAULT 0 AFTER paid_amount");
        DB::statement("ALTER TABLE walk_ins ADD COLUMN IF NOT EXISTS vat DECIMAL(10, 2) DEFAULT 0 AFTER premium");
        DB::statement("ALTER TABLE walk_ins ADD COLUMN IF NOT EXISTS documentary_stamp_tax DECIMAL(10, 2) DEFAULT 0 AFTER vat");
        DB::statement("ALTER TABLE walk_ins ADD COLUMN IF NOT EXISTS local_gov_tax DECIMAL(10, 2) DEFAULT 0 AFTER documentary_stamp_tax");
        DB::statement("ALTER TABLE walk_ins ADD COLUMN IF NOT EXISTS amount_due DECIMAL(10, 2) DEFAULT 0 AFTER local_gov_tax");
        DB::statement("ALTER TABLE walk_ins ADD COLUMN IF NOT EXISTS premium_remarks LONGTEXT NULL AFTER amount_due");
        DB::statement("ALTER TABLE walk_ins ADD COLUMN IF NOT EXISTS payment_terms VARCHAR(255) NULL AFTER premium_remarks");
        DB::statement("ALTER TABLE walk_ins ADD COLUMN IF NOT EXISTS remarks LONGTEXT NULL AFTER payment_terms");
        DB::statement("ALTER TABLE walk_ins ADD COLUMN IF NOT EXISTS rate DECIMAL(10, 2) DEFAULT 0 AFTER remarks");
        DB::statement("ALTER TABLE walk_ins ADD COLUMN IF NOT EXISTS walkin_payment DECIMAL(10, 2) DEFAULT 0 AFTER rate");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("ALTER TABLE walk_ins DROP COLUMN IF EXISTS premium");
        DB::statement("ALTER TABLE walk_ins DROP COLUMN IF EXISTS vat");
        DB::statement("ALTER TABLE walk_ins DROP COLUMN IF EXISTS documentary_stamp_tax");
        DB::statement("ALTER TABLE walk_ins DROP COLUMN IF EXISTS local_gov_tax");
        DB::statement("ALTER TABLE walk_ins DROP COLUMN IF EXISTS amount_due");
        DB::statement("ALTER TABLE walk_ins DROP COLUMN IF EXISTS premium_remarks");
        DB::statement("ALTER TABLE walk_ins DROP COLUMN IF EXISTS payment_terms");
        DB::statement("ALTER TABLE walk_ins DROP COLUMN IF EXISTS remarks");
        DB::statement("ALTER TABLE walk_ins DROP COLUMN IF EXISTS rate");
        DB::statement("ALTER TABLE walk_ins DROP COLUMN IF EXISTS walkin_payment");
    }
};
