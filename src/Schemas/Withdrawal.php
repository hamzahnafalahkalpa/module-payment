<?php

namespace Hanafalah\ModulePayment\Schemas;

use Hanafalah\ModulePayment\Contracts\Data\BaseWalletTransactionData;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Hanafalah\ModulePayment\Contracts\Schemas\Withdrawal as ContractsWithdrawal;
use Hanafalah\ModulePayment\Contracts\Data\WithdrawalData;

class Withdrawal extends BaseWalletTransaction implements ContractsWithdrawal
{
    protected string $__entity = 'Withdrawal';
    public $withdrawal_model;
    //protected mixed $__order_by_created_at = false; //asc, desc, false

    protected array $__cache = [
        'index' => [
            'name'     => 'withdrawal',
            'tags'     => ['withdrawal', 'withdrawal-index'],
            'duration' => 24 * 60
        ]
    ];


    protected function additionalData(BaseWalletTransactionData $base_wallet_transaction_dto): array{
        return [
            'name' => $base_wallet_transaction_dto->name,
            'reference_type' => $base_wallet_transaction_dto->reference_type,
            'reference_id' => $base_wallet_transaction_dto->reference_id
        ];
    }

    public function prepareStoreWithdrawal(WithdrawalData $withdrawal_dto): Model{
        $withdrawal = $this->prepareStoreBaseWalletTransaction($withdrawal_dto);
        $this->fillingProps($withdrawal,$withdrawal_dto->props);
        $withdrawal->save();
        return $this->withdrawal_model = $withdrawal;
    }

    public function withdrawal(mixed $conditionals = null): Builder{
        return $this->baseWalletTransaction($conditionals);
    }
}