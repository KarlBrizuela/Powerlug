<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWalkInsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('walk_ins', function (Blueprint $table) {
            $table->id();
            $table->string('walkin_number')->unique();
            $table->string('insured_name');
            $table->string('unit');
            $table->string('plate_number');
            $table->string('address');
            $table->string('contact_number');
            $table->string('email');
            $table->string('file_path')->nullable();
            $table->decimal('parts_amount', 10, 2)->default(0);
            $table->decimal('labor_cost', 10, 2)->default(0);
            $table->decimal('materials_cost', 10, 2)->default(0);
            $table->decimal('vat_amount', 10, 2)->default(0);
            $table->decimal('total_amount', 10, 2)->default(0);
            $table->string('payment_type')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('walk_ins');
    }
}
