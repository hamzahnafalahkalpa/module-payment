<?php

namespace Hanafalah\ModulePayment\Schemas;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Hanafalah\ModulePayment\Contracts\Schemas\Deposit as ContractsDeposit;
use Hanafalah\ModulePayment\Contracts\Data\DepositData;

class Deposit extends BaseWalletTransaction implements ContractsDeposit
{
    protected string $__entity = 'Deposit';
    public $deposit_model;
    //protected mixed $__order_by_created_at = false; //asc, desc, false

    protected array $__cache = [
        'index' => [
            'name'     => 'deposit',
            'tags'     => ['deposit', 'deposit-index'],
            'duration' => 24 * 60
        ]
    ];

    public function prepareStoreDeposit(DepositData $deposit_dto): Model{
        $deposit = $this->prepareStoreBaseWalletTransaction($deposit_dto);
        return $this->deposit_model = $deposit;
    }

    public function deposit(mixed $conditionals = null): Builder{
        return $this->baseWalletTransaction($conditionals);
    }
}