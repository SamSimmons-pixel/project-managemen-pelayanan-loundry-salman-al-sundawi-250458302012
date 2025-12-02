<?php

require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Machine;
use App\Models\Rental;

echo "Machines:\n";
foreach (Machine::all() as $machine) {
    echo "ID: {$machine->id}, Machine ID: {$machine->machine_id}, Status: {$machine->status}\n";
}

echo "\nRentals:\n";
foreach (Rental::all() as $rental) {
    echo "ID: {$rental->id}, Machine ID: {$rental->machine_id}, User ID: {$rental->user_id}, Status: {$rental->status}, Created At: {$rental->created_at}\n";
}
