<?php

namespace Database\Seeders;

use App\Models\UserExtension;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserExtensionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        UserExtension::create(['user_id' => 3,'branch_id'=>1,'role_id'=>1]);
    }
}
