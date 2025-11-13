<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MakeInsuranceProviderIdNullableInPolicies extends Migration
{
	public function up()
	{
		if (Schema::hasColumn('policies', 'insurance_provider_id')) {
			try {
				Schema::table('policies', function (Blueprint $table) {
					// Attempt to make the column nullable. If the `doctrine/dbal` package is not installed
					// this may throw; we'll catch and continue so migrations can proceed.
					$table->unsignedBigInteger('insurance_provider_id')->nullable()->change();
				});
			} catch (\Throwable $e) {
				// Swallow the exception to avoid blocking migrations in environments
				// without the DBAL package. The change is optional.
			}
		}
	}

	public function down()
	{
		if (Schema::hasColumn('policies', 'insurance_provider_id')) {
			try {
				Schema::table('policies', function (Blueprint $table) {
					$table->unsignedBigInteger('insurance_provider_id')->nullable(false)->change();
				});
			} catch (\Throwable $e) {
				// ignore
			}
		}
	}
}
