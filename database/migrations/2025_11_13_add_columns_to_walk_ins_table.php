<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
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
        // Use raw SQL to add columns if they don't exist
        DB::statement("ALTER TABLE walk_ins ADD COLUMN IF NOT EXISTS walkin_number VARCHAR(255) UNIQUE AFTER id");
        DB::statement("ALTER TABLE walk_ins ADD COLUMN IF NOT EXISTS insured_name VARCHAR(255) AFTER walkin_number");
        DB::statement("ALTER TABLE walk_ins ADD COLUMN IF NOT EXISTS unit VARCHAR(255) AFTER insured_name");
        DB::statement("ALTER TABLE walk_ins ADD COLUMN IF NOT EXISTS plate_number VARCHAR(255) AFTER unit");
        DB::statement("ALTER TABLE walk_ins ADD COLUMN IF NOT EXISTS address VARCHAR(255) AFTER plate_number");
        DB::statement("ALTER TABLE walk_ins ADD COLUMN IF NOT EXISTS contact_number VARCHAR(255) AFTER address");
        DB::statement("ALTER TABLE walk_ins ADD COLUMN IF NOT EXISTS email VARCHAR(255) AFTER contact_number");
        DB::statement("ALTER TABLE walk_ins ADD COLUMN IF NOT EXISTS file_path VARCHAR(255) NULL AFTER email");
        DB::statement("ALTER TABLE walk_ins ADD COLUMN IF NOT EXISTS parts_amount DECIMAL(10, 2) DEFAULT 0 AFTER file_path");
        DB::statement("ALTER TABLE walk_ins ADD COLUMN IF NOT EXISTS labor_cost DECIMAL(10, 2) DEFAULT 0 AFTER parts_amount");
        DB::statement("ALTER TABLE walk_ins ADD COLUMN IF NOT EXISTS materials_cost DECIMAL(10, 2) DEFAULT 0 AFTER labor_cost");
        DB::statement("ALTER TABLE walk_ins ADD COLUMN IF NOT EXISTS vat_amount DECIMAL(10, 2) DEFAULT 0 AFTER materials_cost");
        DB::statement("ALTER TABLE walk_ins ADD COLUMN IF NOT EXISTS total_amount DECIMAL(10, 2) DEFAULT 0 AFTER vat_amount");
        DB::statement("ALTER TABLE walk_ins ADD COLUMN IF NOT EXISTS payment_type VARCHAR(255) NULL AFTER total_amount");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement("ALTER TABLE walk_ins DROP COLUMN IF EXISTS walkin_number");
        DB::statement("ALTER TABLE walk_ins DROP COLUMN IF EXISTS insured_name");
        DB::statement("ALTER TABLE walk_ins DROP COLUMN IF EXISTS unit");
        DB::statement("ALTER TABLE walk_ins DROP COLUMN IF EXISTS plate_number");
        DB::statement("ALTER TABLE walk_ins DROP COLUMN IF EXISTS address");
        DB::statement("ALTER TABLE walk_ins DROP COLUMN IF EXISTS contact_number");
        DB::statement("ALTER TABLE walk_ins DROP COLUMN IF EXISTS email");
        DB::statement("ALTER TABLE walk_ins DROP COLUMN IF EXISTS file_path");
        DB::statement("ALTER TABLE walk_ins DROP COLUMN IF EXISTS parts_amount");
        DB::statement("ALTER TABLE walk_ins DROP COLUMN IF EXISTS labor_cost");
        DB::statement("ALTER TABLE walk_ins DROP COLUMN IF EXISTS materials_cost");
        DB::statement("ALTER TABLE walk_ins DROP COLUMN IF EXISTS vat_amount");
        DB::statement("ALTER TABLE walk_ins DROP COLUMN IF EXISTS total_amount");
        DB::statement("ALTER TABLE walk_ins DROP COLUMN IF EXISTS payment_type");
    }
};
