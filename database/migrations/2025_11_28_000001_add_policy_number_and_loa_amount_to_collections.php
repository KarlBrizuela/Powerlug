<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPolicyNumberAndLoaAmountToCollections extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('collections', function (Blueprint $table) {
            // Add policy_number field
            if (!Schema::hasColumn('collections', 'policy_number')) {
                $table->string('policy_number')->nullable()->after('invoice_number');
            }

            // Add loa_amount field
            if (!Schema::hasColumn('collections', 'loa_amount')) {
                $table->decimal('loa_amount', 12, 2)->nullable()->after('collection_amount');
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
        Schema::table('collections', function (Blueprint $table) {
            // Drop new columns
            if (Schema::hasColumn('collections', 'policy_number')) {
                $table->dropColumn('policy_number');
            }

            if (Schema::hasColumn('collections', 'loa_amount')) {
                $table->dropColumn('loa_amount');
            }
        });
    }
}
