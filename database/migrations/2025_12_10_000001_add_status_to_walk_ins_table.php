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
        DB::statement("ALTER TABLE walk_ins ADD COLUMN IF NOT EXISTS status VARCHAR(255) DEFAULT 'pending' AFTER payment_type");
        DB::statement("ALTER TABLE walk_ins ADD COLUMN IF NOT EXISTS paid_amount DECIMAL(10, 2) DEFAULT 0 AFTER status");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("ALTER TABLE walk_ins DROP COLUMN IF EXISTS status");
        DB::statement("ALTER TABLE walk_ins DROP COLUMN IF EXISTS paid_amount");
    }
};
