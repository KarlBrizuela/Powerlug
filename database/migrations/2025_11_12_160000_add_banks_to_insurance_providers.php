<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddBanksToInsuranceProviders extends Migration
{
	public function up()
	{
		if (!Schema::hasColumn('insurance_providers', 'banks')) {
			Schema::table('insurance_providers', function (Blueprint $table) {
				$table->json('banks')->nullable()->after('is_active');
			});
		}
	}

	public function down()
	{
		if (Schema::hasColumn('insurance_providers', 'banks')) {
			Schema::table('insurance_providers', function (Blueprint $table) {
				$table->dropColumn('banks');
			});
		}
	}
}
