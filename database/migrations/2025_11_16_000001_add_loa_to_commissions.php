<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddLoaToCommissions extends Migration
{
    public function up()
    {
        Schema::table('commissions', function (Blueprint $table) {
            $table->string('loa')->nullable()->after('remarks');
        });
    }

    public function down()
    {
        Schema::table('commissions', function (Blueprint $table) {
            $table->dropColumn('loa');
        });
    }
}
