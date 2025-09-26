<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Branch;

class BranchSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //Branch::create(['name' => 'Mabini','code' => 'MB']);
        Branch::create(['name' => 'Marcos Highway','code'=>'MH']);
        Branch::create(['name' => 'Warehouse','code'=>'WH']);
    }
}
