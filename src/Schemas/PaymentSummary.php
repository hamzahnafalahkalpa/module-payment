<?php

namespace Hanafalah\ModulePayment\Schemas;

use Hanafalah\LaravelSupport\Supports\PackageManagement;
use Hanafalah\ModulePayment\Contracts\Data\PaymentSummaryData;
use Hanafalah\ModulePayment\Contracts\Schemas\PaymentSummary as ContractsPaymentSummary;
use Illuminate\Database\Eloquent\Model;

class PaymentSummary extends PackageManagement implements ContractsPaymentSummary
{
    protected string $__entity = 'PaymentSummary';
    public $payment_summary_model;

    public function prepareStore(PaymentSummaryData $payment_summary_dto) : Model{
        return $this->prepareStorePaymentSummary($payment_summary_dto);
    }

    public function prepareStorePaymentSummary(PaymentSummaryData $payment_summary_dto): Model{
        $add = [
            'parent_id'      => $payment_summary_dto->parent_id,
            'transaction_id' => $payment_summary_dto->transaction_id
        ];
        if (isset($payment_summary_dto->amount)){
            $add['amount'] = $payment_summary_dto->amount;
        }
        if (isset($payment_summary_dto->debt)){
            $add['debt'] = $payment_summary_dto->debt;
        }
        if (isset($payment_summary_dto->id)){
            $guard  = ['id' => $payment_summary_dto->id];
        }else{
            $guard  = [
                'parent_id'      => $payment_summary_dto->parent_id,
                'reference_type' => $payment_summary_dto->reference_type,
                'reference_id'   => $payment_summary_dto->reference_id
            ];
        }
        $create = [$guard,$add];
        $payment_summary = $this->usingEntity()->updateOrCreate(...$create);

        if (isset($payment_summary_dto->payment_details) && count($payment_summary_dto->payment_details) > 0) {
            foreach ($payment_summary_dto->payment_details as &$payment_detail_dto) {
                $payment_detail_dto->payment_summary_id = $payment_summary->getKey();
                $this->schemaContract('payment_detail')->prepareStorePaymentDetail($payment_detail_dto);
            }
        }

        if (isset($payment_summary_dto->payment_summaries) && count($payment_summary_dto->payment_summaries) > 0) {
            foreach ($payment_summary_dto->payment_summaries as &$payment_summary_dto) {
                $payment_summary_dto->parent_id = $payment_summary->getKey();
                $this->prepareStorePaymentSummary($payment_summary_dto);
            }
        }

        $this->fillingProps($payment_summary, $payment_summary_dto->props);
        $payment_summary->save();
        return $this->payment_summary_model = $payment_summary;
    }
}
