<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('claims', function (Blueprint $table) {
            if (!Schema::hasColumn('claims', 'admin_status')) {
                $table->enum('admin_status', ['billed', 'pending'])->default('pending')->after('total_amount');
            }

            if (!Schema::hasColumn('claims', 'superadmin_status')) {
                $table->enum('superadmin_status', ['cleared', 'deposited'])->nullable()->after('admin_status');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('claims', function (Blueprint $table) {
            $table->dropColumn(['admin_status', 'superadmin_status']);
        });
    }
};
