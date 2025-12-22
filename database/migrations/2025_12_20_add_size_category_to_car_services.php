<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('car_services', function (Blueprint $table) {
            if (!Schema::hasColumn('car_services', 'size_category_id')) {
                $table->unsignedBigInteger('size_category_id')->nullable()->after('price');
                $table->foreign('size_category_id')
                      ->references('id')
                      ->on('size_categories')
                      ->onDelete('set null');
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
        Schema::table('car_services', function (Blueprint $table) {
            $table->dropForeignIdFor('SizeCategory');
            $table->dropColumn('size_category_id');
        });
    }
};

