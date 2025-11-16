<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddLoaToCollections extends Migration
{
    public function up()
    {
        Schema::table('collections', function (Blueprint $table) {
            $table->string('loa')->nullable()->after('bank_name');
        });
    }

    public function down()
    {
        Schema::table('collections', function (Blueprint $table) {
            $table->dropColumn('loa');
        });
    }
}
