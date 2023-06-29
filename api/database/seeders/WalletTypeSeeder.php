<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class WalletTypeSeeder extends Seeder
{
    public function run()
    {
        DB::table('wallet_types')->insert(['name' => 'PayPal', 'wallet_symbol' => '$']);
        DB::table('wallet_types')->insert(['name' => 'Payoneer', 'wallet_symbol' => '$']);
        DB::table('wallet_types')->insert(['name' => 'Банковская карта', 'wallet_symbol' => '$']);
        DB::table('wallet_types')->insert(['name' => 'Личный баланс', 'wallet_symbol' => '$']);
    }
}
