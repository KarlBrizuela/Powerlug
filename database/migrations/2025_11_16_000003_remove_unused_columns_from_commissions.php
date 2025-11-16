<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RemoveUnusedColumnsFromCommissions extends Migration
{
    public function up()
    {
        Schema::table('commissions', function (Blueprint $table) {
            $table->dropColumn(['days_30', 'days_60', 'days_90', 'last_pdc_date']);
        });
    }

    public function down()
    {
        Schema::table('commissions', function (Blueprint $table) {
            $table->decimal('days_30', 10, 2)->default(0);
            $table->decimal('days_60', 10, 2)->default(0);
            $table->decimal('days_90', 10, 2)->default(0);
            $table->date('last_pdc_date')->nullable();
        });
    }
}
