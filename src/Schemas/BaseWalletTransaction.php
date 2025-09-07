<?php

namespace Hanafalah\ModulePayment\Schemas;

use Hanafalah\ModulePayment\Contracts\Data\BaseWalletTransactionData;
use Hanafalah\ModulePayment\Contracts\Schemas\BaseWalletTransaction as ContractsBaseWalletTransaction;
use Hanafalah\ModulePayment\Supports\BaseModulePayment;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class BaseWalletTransaction extends BaseModulePayment implements ContractsBaseWalletTransaction
{
    protected string $__entity = 'BaseWalletTransaction';
    public $base_wallet_transaction_model;

    protected function additionalData(BaseWalletTransactionData $base_wallet_transaction_dto): array{
        return [
            'name'       => $base_wallet_transaction_dto->name,
            'channel_id' => $base_wallet_transaction_dto->channel_id,
        ];
    }

    public function prepareStoreBaseWalletTransaction(BaseWalletTransactionData $base_wallet_transaction_dto): Model{
        $add = $this->additionalData($base_wallet_transaction_dto);

        if (isset($base_wallet_transaction_dto->id)){
            $guard = ['id' => $base_wallet_transaction_dto->id];
            $create = [$guard,$add];
        }else{
            $create = [$add];
        }
        $model = $this->usingEntity()->updateOrCreate(...$create);

        if (isset($base_wallet_transaction_dto->wallet_transaction)){
            $wallet_transaction_dto = &$base_wallet_transaction_dto->wallet_transaction;
            $wallet_transaction_dto->reference_type = $model->getMorphClass();
            $wallet_transaction_dto->reference_id = $model->getKey();
            $this->schemaContract('wallet_transaction')->prepareStoreWalletTransaction($wallet_transaction_dto);
        }

        $this->fillingProps($model,$base_wallet_transaction_dto->props->props);
        $model->save();
        return $this->base_wallet_transaction_model = $model;
    }

    public function baseWalletTransaction(mixed $conditionals = null): Builder{
        return $this->generalSchemaModel($conditionals);
    }
}
