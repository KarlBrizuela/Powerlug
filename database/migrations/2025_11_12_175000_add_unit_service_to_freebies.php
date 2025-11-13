<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        if (!Schema::hasColumn('freebies', 'unit') || !Schema::hasColumn('freebies', 'service')) {
            Schema::table('freebies', function (Blueprint $table) {
                if (!Schema::hasColumn('freebies', 'unit')) {
                    $table->string('unit')->nullable()->after('name');
                }
                if (!Schema::hasColumn('freebies', 'service')) {
                    $table->string('service')->nullable()->after('unit');
                }
            });
        }
    }

    public function down()
    {
        Schema::table('freebies', function (Blueprint $table) {
            if (Schema::hasColumn('freebies', 'service')) {
                $table->dropColumn('service');
            }
            if (Schema::hasColumn('freebies', 'unit')) {
                $table->dropColumn('unit');
            }
        });
    }
};
