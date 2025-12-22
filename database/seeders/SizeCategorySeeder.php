<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\SizeCategory;

class SizeCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = [
            ['name' => 'Small', 'description' => 'Small cars (e.g., Honda Jazz, Toyota Yaris)'],
            ['name' => 'Medium', 'description' => 'Medium-sized vehicles (e.g., Honda Civic, Toyota Corolla)'],
            ['name' => 'Large', 'description' => 'Large vehicles (e.g., Honda Accord, Toyota Camry)'],
            ['name' => 'X-Large', 'description' => 'Extra-large vehicles (e.g., SUVs, crossovers)'],
            ['name' => 'XXL-Large', 'description' => 'Extra-extra-large vehicles (e.g., full-size SUVs, trucks)'],
        ];

        foreach ($categories as $category) {
            SizeCategory::firstOrCreate(
                ['name' => $category['name']],
                ['description' => $category['description']]
            );
        }
    }
}
