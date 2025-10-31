<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ProductActivity;

class ProductActivitiesTableSeeder extends Seeder
{
    public function run(): void
    {
        $activities = [
            'Restocked',
            'Price Update',
            'Sales',
            'Added',
            'Updated',
            'Out Of Stock',
            'Returned',
            'Removed',
            'Defective',
        ];

        foreach ($activities as $activity) {
            // Insert activity if it doesn't exist
            ProductActivity::firstOrCreate(['activity' => $activity]);
        }
    }
}
