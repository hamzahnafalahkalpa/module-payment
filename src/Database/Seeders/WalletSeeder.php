<?php

namespace Hanafalah\ModulePayment\Database\Seeders;

use Hanafalah\LaravelSupport\Concerns\Support\HasRequestData;
use Hanafalah\ModulePayment\Contracts\Data\WalletData;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class WalletSeeder extends Seeder
{
    use HasRequestData;

    public function run(): void
    {
        echo "[DEBUG] Booting ".class_basename($this)."\n";
        $wallets = [
            [
                'name' => 'Personal Pocket',
                'label' => 'PERSONAL',
                'reference_type' => null,
                'reference_id' => null
            ]
        ];

        foreach ($wallets as $wallet) {
            app(config('app.contracts.Wallet'))->prepareStoreWallet($this->requestDTO(WalletData::class, $wallet));
        }
    }
}
