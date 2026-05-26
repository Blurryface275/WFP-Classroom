<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
    

class CategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        DB::table('categories')->insert([
            ['Category_name' => 'Health'],
            ['Category_name' => 'Specialist Consultation'],
            ['Category_name' => 'Medical Checkup'],
            ['Category_name' => 'Laboratory Tests'],
            ['Category_name' => 'Telemedicine'],
        ]);
    }
}
