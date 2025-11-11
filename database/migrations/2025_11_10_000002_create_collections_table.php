<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCollectionsTable extends Migration
{
    public function up()
    {
        Schema::create('collections', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_id')->nullable()->constrained()->onDelete('cascade');
            $table->string('invoice_number')->unique();
            $table->decimal('collection_amount', 10, 2);
            $table->string('payment_method');
            $table->string('collection_status');
            $table->string('bank_name')->nullable();
            $table->date('collection_date');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('collections');
    }
}
