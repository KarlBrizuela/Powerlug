<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('commissions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('policy_id')->index();
            $table->unsignedBigInteger('insurance_provider_id')->index();
            $table->string('policy_number');
            $table->string('insured');
            $table->string('term'); // e.g., "12 Months", "6 Months"
            $table->decimal('gross_premium', 10, 2);
            $table->decimal('net_premium', 10, 2);
            $table->decimal('days_30', 10, 2)->default(0);
            $table->decimal('days_60', 10, 2)->default(0);
            $table->decimal('days_90', 10, 2)->default(0);
            $table->date('last_pdc_date')->nullable(); // Last Date of PDC & Installment / Current Date of Full Payment
            $table->decimal('commission_amount', 10, 2);
            $table->decimal('commission_rate', 5, 2)->default(15.00); // Commission rate percentage
            $table->enum('payment_status', ['pending', 'partial', 'paid'])->default('pending');
            $table->text('remarks')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();
            $table->softDeletes();

            // Foreign keys
            $table->foreign('policy_id')->references('id')->on('policies')->onDelete('cascade');
            $table->foreign('insurance_provider_id')->references('id')->on('insurance_providers')->onDelete('cascade');
            $table->foreign('created_by')->references('id')->on('users')->onDelete('set null');
            $table->foreign('updated_by')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('commissions');
    }
};
