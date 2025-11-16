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
        // Add columns only if they don't already exist to make this migration idempotent
        Schema::table('claims', function (Blueprint $table) {
            if (!Schema::hasColumn('claims', 'insurance_provider_id')) {
                $table->unsignedBigInteger('insurance_provider_id')->nullable()->after('client_name');
            }

            if (!Schema::hasColumn('claims', 'policy_id')) {
                $table->unsignedBigInteger('policy_id')->nullable()->after('insurance_provider_id');
            }

            if (!Schema::hasColumn('claims', 'policy_number')) {
                $table->string('policy_number')->nullable()->after('policy_id');
            }
        });

        // NOTE: foreign keys intentionally omitted here when running on existing databases
        // to avoid duplicate foreign key errors. If you need the foreign keys created on
        // a fresh database, ensure migrations run in a clean environment or add them
        // manually.
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('claims', function (Blueprint $table) {
            $table->dropForeign(['insurance_provider_id']);
            $table->dropForeign(['policy_id']);
            $table->dropColumn(['insurance_provider_id', 'policy_id', 'policy_number']);
        });
    }
};
