<?php

namespace Hanafalah\ModulePayment\Schemas;

use Hanafalah\ModulePayment\Contracts\Data\PosTransactionData;
use Illuminate\Database\Eloquent\Model;
use Hanafalah\ModulePayment\Contracts\Schemas\PosTransaction as ContractsPosTransaction;
use Hanafalah\ModuleTransaction\Schemas\Transaction;
use Illuminate\Database\Eloquent\Builder;

class PosTransaction extends Transaction implements ContractsPosTransaction
{
    protected string $__entity = 'PosTransaction';
    public $pos_transaction_model;

    public function prepareStorePosTransaction(PosTransactionData $pos_transaction_dto): Model{
        $transaction = parent::prepareStoreTransaction($pos_transaction_dto);
        if (isset($pos_transaction_dto->billing)){
            $billing_dto = &$pos_transaction_dto->billing;
            $billing_dto->has_transaction_id = $transaction->getKey();
            if (isset($billing_dto->invoices) && count($billing_dto->invoices) > 0){ 
                $consument = $transaction->consument;
                if (isset($consument)){
                    foreach ($billing_dto->invoices as &$invoice) {
                        if (!isset($invoice->payer_type) || !isset($invoice->payer_id)){
                            $invoice->payer_type = $consument->getMorphClass();
                            $invoice->payer_id = $consument->getKey();
                        }
                    }
                }
            }
            $billing_model = $this->schemaContract('billing')->prepareStoreBilling($billing_dto);
            $pos_transaction_dto->props['prop_billing'] = $billing_model->toViewApi()->resolve();
        }
        $this->fillingProps($transaction, $pos_transaction_dto->props);
        $transaction->save();
        return $this->pos_transaction_model = $transaction; 
    }

    public function camelEntity(): string{
        return 'posTransaction';
    }

    public function posTransaction(mixed $conditionals = null): Builder{
        return $this->trx($conditionals);
    }
}
