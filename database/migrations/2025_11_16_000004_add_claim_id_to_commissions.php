<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddClaimIdToCommissions extends Migration
{
    public function up()
    {
        Schema::table('commissions', function (Blueprint $table) {
            $table->unsignedBigInteger('claim_id')->nullable()->after('policy_id')->index();
            $table->foreign('claim_id')->references('id')->on('claims')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::table('commissions', function (Blueprint $table) {
            $table->dropForeign(['claim_id']);
            $table->dropColumn('claim_id');
        });
    }
}
