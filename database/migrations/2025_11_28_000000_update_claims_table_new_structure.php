<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateClaimsTableNewStructure extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('claims', function (Blueprint $table) {
            // Add claim_number field if it doesn't exist
            if (!Schema::hasColumn('claims', 'claim_number')) {
                $table->string('claim_number')->unique()->after('policy_number');
            }

            // Add new fields for the simplified claim amount structure
            if (!Schema::hasColumn('claims', 'deductible_participation')) {
                $table->decimal('deductible_participation', 12, 2)->nullable()->after('loa_amount');
            }

            // Drop old fields that are no longer needed
            $oldColumns = ['parts', 'labor_cost', 'materials', 'vat', 'deductible', 'participation_amount'];
            foreach ($oldColumns as $column) {
                if (Schema::hasColumn('claims', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('claims', function (Blueprint $table) {
            // Add back the old columns
            $table->decimal('parts', 12, 2)->nullable();
            $table->decimal('labor_cost', 12, 2)->nullable();
            $table->decimal('materials', 12, 2)->nullable();
            $table->decimal('vat', 12, 2)->nullable();
            $table->decimal('deductible', 12, 2)->nullable();
            $table->decimal('participation_amount', 12, 2)->nullable();

            // Drop new columns
            if (Schema::hasColumn('claims', 'deductible_participation')) {
                $table->dropColumn('deductible_participation');
            }

            if (Schema::hasColumn('claims', 'claim_number')) {
                $table->dropColumn('claim_number');
            }
        });
    }
}
