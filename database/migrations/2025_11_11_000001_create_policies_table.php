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
        Schema::create('policies', function (Blueprint $table) {
            $table->id();
            $table->string('policy_number')->unique();
            $table->foreignId('client_id')->constrained('clients')->onDelete('cascade');
            $table->foreignId('insurance_provider_id')->constrained('insurance_providers')->onDelete('cascade');
            $table->decimal('coverage_amount', 12, 2);
            $table->decimal('premium', 10, 2);
            $table->string('policy_type')->default('individual'); // individual, family, corporate
            $table->date('start_date');
            $table->date('end_date');
            $table->enum('status', ['active', 'inactive', 'expired', 'cancelled'])->default('active');
            $table->text('remarks')->nullable();
            $table->string('payment_method')->nullable(); // cash, bank_transfer, check
            $table->enum('billing_status', ['paid', 'unpaid', 'partial'])->default('unpaid');
            $table->foreignId('created_by')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignId('updated_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('policies');
    }
};
