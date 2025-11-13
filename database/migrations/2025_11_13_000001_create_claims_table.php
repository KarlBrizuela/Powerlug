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
        Schema::create('claims', function (Blueprint $table) {
            $table->id();
            $table->date('date_of_claim')->nullable();
            $table->string('client_name')->nullable();
            $table->string('claim_number')->nullable();
            $table->decimal('loa_amount', 12, 2)->nullable();
            $table->decimal('participation_amount', 12, 2)->nullable();
            $table->decimal('deductible', 12, 2)->nullable();
            $table->string('file_path')->nullable();
            $table->decimal('parts', 12, 2)->nullable();
            $table->decimal('labor_cost', 12, 2)->nullable();
            $table->decimal('materials', 12, 2)->nullable();
            $table->decimal('vat', 12, 2)->nullable();
            $table->decimal('total_amount', 12, 2)->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('claims');
    }
};
