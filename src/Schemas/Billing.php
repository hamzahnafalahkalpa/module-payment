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
        $billing->load('transaction');

        if (isset($billing_dto->transaction)){
            $transaction_dto = &$billing_dto->transaction;
            $transaction_dto->id = $billing->transaction->getKey();
            $transaction_dto->reference_type = $billing->getMorphClass();
            $transaction_dto->reference_id   = $billing->getKey();
            $this->schemaContract('transaction')->prepareStoreTransaction($transaction_dto);
        }

        if (isset($billing_dto->split_bills) && count($billing_dto->split_bills) > 0){
            $split_bill_schema = $this->schemaContract('split_bill');
            foreach ($billing_dto->split_bills as &$split_bill_dto) {
                $split_bill_dto->billing_id = $billing->getKey();
                $split_bill_dto->billing_model = $billing;
                $split_bill_schema->prepareStoreSplitBill($split_bill_dto);
            }
        }
        $this->fillingProps($billing, $billing_dto->props);
        $billing->save();
        return $this->billing_model = $billing;
    }
}
