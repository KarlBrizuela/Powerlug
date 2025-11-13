<?php

require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Freebie;

$f = Freebie::create([
    'name' => 'CLI Insert Freebie',
    'description' => 'Inserted via script',
    'unit' => 'pc',
    'service' => 'test',
    'schedule_type' => null,
    'schedule_value' => null,
    'is_active' => 1,
    'start_date' => null,
    'end_date' => null,
]);

echo "Inserted freebie id: {$f->id}\n";
