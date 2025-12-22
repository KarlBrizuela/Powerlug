<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('commissions', function (Blueprint $table) {
            if (!Schema::hasColumn('commissions', 'walk_in_id')) {
                $table->unsignedBigInteger('walk_in_id')->nullable()->after('claim_id')->index();
                $table->foreign('walk_in_id')->references('id')->on('walk_ins')->onDelete('set null');
            }
        });
    }

    public function down()
    {
        Schema::table('commissions', function (Blueprint $table) {
            if (Schema::hasColumn('commissions', 'walk_in_id')) {
                $table->dropForeign(['walk_in_id']);
                $table->dropColumn('walk_in_id');
            }
        });
    }
};
