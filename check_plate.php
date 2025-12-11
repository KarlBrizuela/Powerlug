<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

$client = \App\Models\Client::first();
if($client) {
    echo "All columns: " . implode(', ', array_keys($client->getAttributes())) . PHP_EOL;
}

$clients = \App\Models\Client::limit(5)->get();

foreach($clients as $c) {
    echo $c->firstName . ' ' . $c->lastName . ' | Plate: [' . ($c->plate_no ?? 'NULL') . '] | Make: [' . ($c->make_model ?? 'NULL') . '] | Color: [' . ($c->color ?? 'NULL') . '] | Year: [' . ($c->model_year ?? 'NULL') . ']' . PHP_EOL;
}
