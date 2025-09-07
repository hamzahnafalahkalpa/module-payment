<?php

namespace Hanafalah\ModulePayment\Schemas;

use Illuminate\Database\Eloquent\Model;
use Hanafalah\ModulePayment\{
    Supports\BaseModulePayment
};
use Hanafalah\ModulePayment\Contracts\Schemas\WalletTransaction as ContractsWalletTransaction;
use Hanafalah\ModulePayment\Contracts\Data\WalletTransactionData;

class WalletTransaction extends BaseModulePayment implements ContractsWalletTransaction
{
    protected string $__entity = 'WalletTransaction';
    public $wallet_transaction_model;
    //protected mixed $__order_by_created_at = false; //asc, desc, false

    protected array $__cache = [
        'index' => [
            'name'     => 'wallet_transaction',
            'tags'     => ['wallet_transaction', 'wallet_transaction-index'],
            'duration' => 24 * 60
        ]
    ];

    public function prepareStoreWalletTransaction(WalletTransactionData $wallet_transaction_dto): Model{
        $add = [
            'name' => $wallet_transaction_dto->name,            
            'nominal' => $wallet_transaction_dto->nominal,
            'author_type' => $wallet_transaction_dto->author_type,
            'author_id' => $wallet_transaction_dto->author_id,
            'previous_balance' => $wallet_transaction_dto->previous_balance,
            'current_balance' => $wallet_transaction_dto->current_balance,
            'reported_at' => $wallet_transaction_dto->reported_at
        ];
        if (isset($wallet_transaction_dto->id)){
            $guard = ['id' => $wallet_transaction_dto->id];
        }else{
            $guard = [
                'transaction_type' => $wallet_transaction_dto->transaction_type,
                'wallet_id' => $wallet_transaction_dto->wallet_id,
                'user_wallet_id' => $wallet_transaction_dto->user_wallet_id,
                'reference_type' => $wallet_transaction_dto->reference_type,
                'reference_id' => $wallet_transaction_dto->reference_id,
                'consument_type' => $wallet_transaction_dto->consument_type,
                'consument_id' => $wallet_transaction_dto->consument_id,
            ];
        }
        $create = [$guard, $add];
        $wallet_transaction = $this->usingEntity()->updateOrCreate(...$create);

        $this->schemaContract('user_wallet')->pepareBalanceAdjustment(
            $this->requestDTO(
                config('app.contracts.UserWalletAdjustmentData'),[
                    'id' => $wallet_transaction_dto->user_wallet_id,
                    'user_wallet_model' => $wallet_transaction_dto->user_wallet_model,
                    'balance' => $wallet_transaction_dto->current_balance
                ]
            )
        );

        $this->fillingProps($wallet_transaction,$wallet_transaction_dto->props);
        $wallet_transaction->save();
        return $this->wallet_transaction_model = $wallet_transaction;
    }
}