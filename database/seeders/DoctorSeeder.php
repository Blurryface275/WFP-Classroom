<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class DoctorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        DB::table('doctors')->insert([
            'name' => Str::random(10),
            'email' => Str::random(10) . '@example.com',
            'password' => Str::random(10),
            'phone' => Str::random(10),
            'address' => Str::random(20),
            'photo' => Str::random(10) . '.jpg',
            'description' => Str::random(50),
            'specialist' => Str::random(20),
            'gender' => Str::random('10'),
        ]);
    }
}
