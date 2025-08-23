<?php

namespace Hanafalah\ModulePayment\Schemas;

use Illuminate\Database\Eloquent\Model;
use Hanafalah\ModulePayment\Contracts\Schemas\PosTransaction as ContractsPosTransaction;
use Hanafalah\ModuleTransaction\Contracts\Data\TransactionData;
use Hanafalah\ModuleTransaction\Schemas\Transaction;

class PosTransaction extends Transaction implements ContractsPosTransaction
{
    protected string $__entity = 'PosTransaction';
    public $transaction_model;

    public function prepareStoreTransaction(TransactionData $transaction_dto): Model{
        $transaction = parent::prepareStoreTransaction($transaction_dto);
        if (isset($transaction_dto->billing)){
            $billing_dto = &$transaction_dto->billing;
            $billing_dto->has_transaction_id = $transaction->getKey();
            $billing_model = $this->schemaContract('billing')->prepareStoreBilling($billing_dto);
            $transaction_dto->prop['prop_billing'] = $billing_model->toViewApi()->resolve();
        }
        $this->fillingProps($transaction, $transaction_dto->props);
        $transaction->save();
        return $this->transaction_model = $transaction; 
    }

    // public $billing_model;

    // public function prepareCheckout(?array $attributes = null): Model
    // {
    //     $attributes ??= request()->all();
    //     if (!isset($attributes['uuid'])) throw new \Exception('uuid is required');
    //     $transaction = $this->TransactionModel()->where('uuid', $attributes['uuid'])->firstOrFail();

    //     if (!isset($transaction->split_bills) || count($transaction->split_bills) == 0) throw new \Exception('The transaction has not been billed');

    //     $billing = $this->schemaContract('billing')->prepareStoreBilling([
    //         'transaction_id' => $transaction->getKey(),
    //         'cashier_id'     => $attributes['cashier_id'],
    //         'cashier_type'   => $attributes['cashier_type'],
    //         'author_type'    => $attributes['author_type'] ?? null,
    //         'author_id'      => $attributes['author_id'] ?? null,
    //         'split_bills'    => $transaction->split_bills,
    //         'reported_at'    => now()
    //     ]);
    //     return $this->billing_model = $billing;
    // }

    // public function checkout(): array
    // {
    //     return $this->transaction(function () {
    //         return $this->schemaContract('billing')
    //             ->checkoutBilling($this->prepareCheckout());
    //     });
    // }

    // public function prepareStorePaidPayment(?array $attributes = null): Model
    // {
    //     $attributes ??= request()->all();

    //     if (!isset($attributes['uuid'])) throw new \Exception('uuid is required');
    //     $transaction  = $this->TransactionModel()->where('uuid', $attributes['uuid'])->firstOrFail();
    //     if (!isset($attributes['split_bills']) || count($attributes['split_bills']) == 0) throw new \Exception('split_bills is required');
    //     $billing = $this->schemaContract('billing')->prepareStoreBilling([
    //         'transaction'    => $transaction,
    //         'transaction_id' => $transaction->getKey(),
    //         'cashier_id'     => $attributes['cashier_id'],
    //         'cashier_type'   => $attributes['cashier_type'],
    //         'author_type'    => $attributes['author_type'] ?? null,
    //         'author_id'      => $attributes['author_id'] ?? null,
    //         'split_bills'    => $attributes['split_bills'] ?? $attributes['split_bill'] ?? []
    //     ]);
    //     return $this->billing_model = $billing;
    // }

    // public function storePaidPayment(): array
    // {
    //     return $this->transaction(function () {
    //         return $this->schemaContract('billing')
    //             ->showBilling($this->prepareStorePaidPayment());
    //     });
    // }

    // protected function getTransactionBuilder($morphs)
    // {
    //     $status = $this->getTransactionStatus();
    //     $morphs = $this->mustArray($morphs);
    //     return $this->trx(function ($query) use ($morphs) {
    //         $query->when(isset($morphs), function ($query) use ($morphs) {
    //             $query->whereIn('reference_type', $morphs);
    //         });
    //     })->with('reference')
    //         ->whereHasMorph('reference', $this->VisitPatientModel()->getMorphClass(), function ($query) {
    //             $query->whereHas('patient');
    //         })->whereHas("paymentSummary", fn($q) => $q->debtNotZero())
    //         ->whereIn('status', [$status['DRAFT'], $status['ACTIVE']]);
    // }
}
