<?php

namespace Hanafalah\ModulePayment\Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder{
    public function run(): void
    {
        $this->call([
            CoaTypeSeeder::class,
            CoaSeeder::class,
            WalletSeeder::class
        ]);
    }
}