<?php

namespace Hanafalah\ModulePayment\Schemas;

use Illuminate\Database\Eloquent\Model;
use Hanafalah\ModulePayment\Contracts\Schemas\Wallet as ContractsWallet;
use Hanafalah\ModulePayment\Contracts\Data\WalletData;

class Wallet extends FinanceStuff implements ContractsWallet
{
    protected string $__entity = 'Wallet';
    public $wallet_model;
    //protected mixed $__order_by_created_at = false; //asc, desc, false

    protected array $__cache = [
        'index' => [
            'name'     => 'wallet',
            'tags'     => ['wallet', 'wallet-index'],
            'duration' => 24 * 60
        ]
    ];

    public function prepareStoreWallet(WalletData $wallet_dto): Model{
        $wallet = $this->prepareStoreFinanceStuff($wallet_dto);
        return $this->wallet_model = $wallet;
    }

    public function wallet(mixed $conditionals = null){
        return $this->financeStuff($conditionals);
    }
}