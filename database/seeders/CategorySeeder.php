<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;
class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Category::create(['category' => 'Cat A']);
        Category::create(['category' => 'Cat B']);
        Category::create(['category' => 'Cat C']);
    }
}
