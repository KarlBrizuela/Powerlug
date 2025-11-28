<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddClaimNumberToCollections extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('collections', function (Blueprint $table) {
            // Add claim_number field
            if (!Schema::hasColumn('collections', 'claim_number')) {
                $table->string('claim_number')->nullable()->after('policy_number');
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
            // Drop claim_number column
            if (Schema::hasColumn('collections', 'claim_number')) {
                $table->dropColumn('claim_number');
            }
        });
    }
}
