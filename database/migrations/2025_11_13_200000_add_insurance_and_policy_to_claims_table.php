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
            $table->unsignedBigInteger('insurance_provider_id')->nullable()->after('client_name');
            $table->unsignedBigInteger('policy_id')->nullable()->after('insurance_provider_id');
            $table->string('policy_number')->nullable()->after('policy_id');
            
            // Add foreign keys
            $table->foreign('insurance_provider_id')->references('id')->on('insurance_providers')->onDelete('set null');
            $table->foreign('policy_id')->references('id')->on('policies')->onDelete('set null');
        });
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
