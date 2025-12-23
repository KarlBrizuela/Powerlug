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
        Schema::table('commissions', function (Blueprint $table) {
            if (!Schema::hasColumn('commissions', 'vat')) {
                $table->decimal('vat', 10, 2)->default(0)->after('gross_premium');
            }
            if (!Schema::hasColumn('commissions', 'documentary_stamp_tax')) {
                $table->decimal('documentary_stamp_tax', 10, 2)->default(0)->after('vat');
            }
            if (!Schema::hasColumn('commissions', 'local_gov_tax')) {
                $table->decimal('local_gov_tax', 10, 2)->default(0)->after('documentary_stamp_tax');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('commissions', function (Blueprint $table) {
            if (Schema::hasColumn('commissions', 'vat')) {
                $table->dropColumn('vat');
            }
            if (Schema::hasColumn('commissions', 'documentary_stamp_tax')) {
                $table->dropColumn('documentary_stamp_tax');
            }
            if (Schema::hasColumn('commissions', 'local_gov_tax')) {
                $table->dropColumn('local_gov_tax');
            }
        });
    }
};
