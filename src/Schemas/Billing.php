<?php

namespace Hanafalah\ModulePayment\Schemas;

use Hanafalah\LaravelSupport\Supports\PackageManagement;
use Hanafalah\ModulePayment\Contracts\Data\BillingData;
use Hanafalah\ModulePayment\Contracts\Schemas\Billing as ContractsBilling;
use Illuminate\Database\Eloquent\Model;

class Billing extends PackageManagement implements ContractsBilling
{
    protected string $__entity = 'Billing';
    public $billing_model;

    public function prepareStoreBilling(BillingData $billing_dto): Model{
        if (isset($billing_dto->id)) {
            $guard = ['id' => $billing_dto->id];
        } else {
            $guard = [
                'reported_at'    => null,
                'has_transaction_id' => $billing_dto->has_transaction_id
            ];
        }

        $billing = $this->usingEntity()->updateOrCreate($guard, [
            'author_type'  => $billing_dto->author_type,
            'author_id'    => $billing_dto->author_id,
            'cashier_type' => $billing_dto->cashier_type,
            'cashier_id'   => $billing_dto->cashier_id,
            'reported_at'  => $billing_dto->reported_at
        ]);
        $billing->load(['transaction','hasTransaction']);

        $billing_dto->props['prop_has_transaction'] = $billing->hasTransaction->toViewApi()->resolve();

        if (isset($billing_dto->transaction)){
            $transaction_dto = &$billing_dto->transaction;
            $transaction_dto->id = $billing->transaction->getKey();
            $transaction_dto->reference_type = $billing->getMorphClass();
            $transaction_dto->reference_id   = $billing->getKey();
            $this->schemaContract('transaction')->prepareStoreTransaction($transaction_dto);
        }

        if (isset($billing_dto->invoices) && count($billing_dto->invoices) > 0){
            $split_payment_schema = $this->schemaContract('invoice');
            foreach ($billing_dto->invoices as &$split_payment_dto) {
                $split_payment_dto->billing_id = $billing->getKey();
                $split_payment_dto->billing_model = $billing;
                $split_payment_schema->prepareStoreSplitPayment($split_payment_dto);
            }
        }
        $this->fillingProps($billing, $billing_dto->props);
        $billing->save();
        return $this->billing_model = $billing;
    }
}
