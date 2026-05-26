<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class TransactionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        DB::table('transactions')->insert([
            'user_id' => 1,
            'service_id' => 1,
            'transaction_date' => now(),
            'status' => str::random(10),
            'total_price' => 100.00,
            'payment_method' => 'credit_card',
        ]);
    }
}
