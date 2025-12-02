<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ServicePackage;

class ServicePackageSeeder extends Seeder
{
    public function run(): void
    {
        $packages = [
            [
                'name' => 'Cuci Kilat (Express)',
                'description' => 'Quick wash service',
                'price_per_kg' => 5000,
                'status' => 'Active',
            ],
            [
                'name' => 'Cuci Setrika (Wash & Iron)',
                'description' => 'Regular wash and iron service',
                'price_per_kg' => 8000,
                'status' => 'Active',
            ],
            [
                'name' => 'Cuci Kering (Dry Clean)',
                'description' => 'Premium dry cleaning service',
                'price_per_kg' => 15000,
                'status' => 'Active',
            ],
        ];

        foreach ($packages as $package) {
            ServicePackage::create($package);
        }
    }
}
