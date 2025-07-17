<?php

namespace Hanafalah\ModulePayment\Schemas;

use Hanafalah\LaravelSupport\Supports\PackageManagement;
use Hanafalah\ModulePayment\Contracts\Data\PaymentSummaryData;
use Hanafalah\ModulePayment\Contracts\Schemas\PaymentSummary as ContractsPaymentSummary;
use Illuminate\Database\Eloquent\Model;

class PaymentSummary extends PackageManagement implements ContractsPaymentSummary
{
    protected string $__entity = 'PaymentSummary';
    public static $payment_summary_model;

    public function prepareStorePaymentSummary(PaymentSummaryData $payment_summary_dto): Model{
        $add = [
            'parent_id' => $payment_summary_dto->parent_id,
            'transaction_id' => $payment_summary_dto->transaction_id
        ];
        if (isset($payment_summary_dto->id)){
            $guard  = ['id' => $payment_summary_dto->id];
        }else{
            $guard  = [
                'reference_type' => $payment_summary_dto->reference_type,
                'reference_id'   => $payment_summary_dto->reference_id
            ];
        }
        $create = [$guard,$add];
        $payment_summary = $this->usingEntity()->updateOrCreate(...$create);
        $this->fillingProps($payment_summary, $payment_summary_dto->props);
        $payment_summary->save();
        return static::$payment_summary_model = $payment_summary;
    }
}
