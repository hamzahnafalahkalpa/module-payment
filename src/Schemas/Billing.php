<?php

namespace Hanafalah\ModulePayment\Schemas;

use Hanafalah\LaravelSupport\Contracts\Data\PaginateData;
use Hanafalah\LaravelSupport\Supports\PackageManagement;
use Hanafalah\ModulePayment\Contracts\Schemas\Billing as ContractsBilling;
use Hanafalah\ModulePayment\Data\BillingData;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;

class Billing extends PackageManagement implements ContractsBilling
{
    protected string $__entity = 'Billing';
    public $billing_model;

    protected function viewUsingRelation(): array{
        return ['hasTransaction.reference'];
    }

    protected function showUsingRelation(): array{
        return [
            'author',
            'transaction',
            'cashier',
            'splitBills.paymentHistory.paymentHistoryDetails'
        ];
    }

    public function getBilling(): mixed{
        return $this->billing_model;
    }

    public function initializeBilling(Model $billing): void{
        $this->billing_model = $billing;
    }

    public function prepareStoreBilling(BillingData $billing_dto): Model{
        if (isset($billing_dto->id)) {
            $guard = ['id' => $billing_dto->id];
        } else {
            $guard = [
                'reported_at'    => null,
                'transaction_id' => $billing_dto->transaction_id
            ];
        }

        $billing = $this->BillingModel()->updateOrCreate($guard, [
            'author_type'  => $billing_dto->author_type,
            'author_id'    => $billing_dto->author_id,
            'cashier_type' => $billing_dto->cashier_type,
            'cashier_id'   => $billing_dto->cashier_id,
            'reported_at'  => $billing_dto->reported_at
        ]);

        $this->createBillingTransaction($billing);

        $split_bill_schema = $this->schemaContract('split_bill');
        if (!isset($billing_dto->split_bills)) throw new \Exception("split bill not found");
        foreach ($billing_dto->split_bills as $split_bill_attr) {
            $split_bill_schema->prepareStoreSplitBill(array_merge($split_bill_attr, [
                'billing'    => $billing,
                'billing_id' => $billing->getKey()
            ]));
        }
        $billing->reported_at = now();
        $billing->save();

        $billing->refresh();
        $billing->load(['splitBills.paymentHistory.paymentHistoryDetails']);

        return $this->billing_model = $billing;
    }

    protected function createBillingTransaction(Model &$billing): void{
        $biling_transaction            = $billing->transaction()->firstOrCreate();
        $biling_transaction->parent_id = $billing->transaction_id;
        $biling_transaction->save();

        $billing->setRelation('transaction', $biling_transaction);
    }

    protected function findBillingById(): Model{
        return $this->billing()->with($this->showUsingRelation())->find(request()->id);
    }

    protected function findBillingByUuid(): Model{
        return $this->billing()->with($this->showUsingRelation())->when(
            isset(request()->uuid),
            fn($q) => $q->uuid(request()->uuid)
        )->first();
    }

    public function showBilling(?Model $model = null): array{
        return $this->showEntityResource(function() use ($model){
            return $this->prepareShowBilling($model);
        });
    }

    public function billing(mixed $conditionals = null): Builder{
        $this->booting();
        return $this->BillingModel()->withParameters()->conditionals($this->mergeCondition($conditionals ?? []))->orderBy('created_at', 'desc');
    }    
}
