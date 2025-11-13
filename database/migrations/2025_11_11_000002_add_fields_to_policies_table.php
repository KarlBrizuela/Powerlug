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
        Schema::table('policies', function (Blueprint $table) {
            // Client information fields
            $table->string('client_name')->nullable()->after('client_id');
            $table->string('address')->nullable()->after('client_name');
            $table->string('email')->nullable()->after('address');
            $table->string('contact_number')->nullable()->after('email');
            
            // Vehicle information fields
            $table->string('make_model')->nullable()->after('contact_number');
            $table->string('plate_number')->nullable()->after('make_model');
            $table->string('model_year')->nullable()->after('plate_number');
            $table->string('color')->nullable()->after('model_year');
            
            // Policy details fields
            $table->string('insurance_provider')->nullable()->after('insurance_provider_id');
            $table->date('issue_date')->nullable()->after('insurance_provider');
            $table->date('coverage_from')->nullable()->after('issue_date');
            $table->date('coverage_to')->nullable()->after('coverage_from');
            $table->string('chassis_number')->nullable()->after('coverage_to');
            $table->string('engine_number')->nullable()->after('chassis_number');
            $table->string('mv_file_number')->nullable()->after('engine_number');
            $table->string('mortgage')->nullable()->after('mv_file_number');
            $table->string('freebie')->nullable()->after('mortgage');
            
            // Walk-in details fields
            $table->date('walkin_date')->nullable()->after('freebie');
            $table->string('walkin_file')->nullable()->after('walkin_date');
            $table->decimal('estimate_amount', 10, 2)->nullable()->after('walkin_file');
            $table->string('size')->nullable()->after('estimate_amount');
            $table->json('services')->nullable()->after('size');
            $table->decimal('rate', 10, 2)->nullable()->after('services');
            $table->decimal('walkin_payment', 10, 2)->nullable()->after('rate');
            
            // Additional payment information
            $table->string('payment_terms')->nullable()->after('walkin_payment');
            $table->decimal('paid_amount', 10, 2)->nullable()->after('payment_terms');
            $table->string('bank_transfer')->nullable()->after('paid_amount');
            $table->string('additional_freebie')->nullable()->after('bank_transfer');
            $table->string('reference_number')->nullable()->after('additional_freebie');
            
            // Premium summary fields
            $table->decimal('vat', 10, 2)->nullable()->after('premium');
            $table->decimal('documentary_stamp_tax', 10, 2)->nullable()->after('vat');
            $table->decimal('local_gov_tax', 10, 2)->nullable()->after('documentary_stamp_tax');
            $table->decimal('amount_due', 10, 2)->nullable()->after('local_gov_tax');
            $table->decimal('coc_vp', 10, 2)->nullable()->after('amount_due');
            $table->text('premium_remarks')->nullable()->after('coc_vp');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('policies', function (Blueprint $table) {
            $table->dropColumn([
                'client_name',
                'address',
                'email',
                'contact_number',
                'make_model',
                'plate_number',
                'model_year',
                'color',
                'insurance_provider',
                'issue_date',
                'coverage_from',
                'coverage_to',
                'chassis_number',
                'engine_number',
                'mv_file_number',
                'mortgage',
                'freebie',
                'walkin_date',
                'walkin_file',
                'estimate_amount',
                'size',
                'services',
                'rate',
                'walkin_payment',
                'payment_terms',
                'paid_amount',
                'bank_transfer',
                'additional_freebie',
                'reference_number',
                'vat',
                'documentary_stamp_tax',
                'local_gov_tax',
                'amount_due',
                'coc_vp',
                'premium_remarks',
            ]);
        });
    }
};
