<?php

namespace Hanafalah\ModulePayment\Resources\Invoice;

use Hanafalah\ModulePayment\Resources\PaymentSummary\ShowPaymentSummary;

class ShowInvoice extends ViewInvoice
{

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray(\Illuminate\Http\Request $request): array
    {
        $arr = [
            'payment_summary' => $this->relationValidation('paymentSummary', function () {
                return $this->paymentSummary->toShowApi();
            }),
            'payment_history' => $this->relationValidation('paymentHistory', function () {
                return $this->paymentHistory->toShowApi();
            }),
            'split_payments' => $this->relationValidation('splitPayments', function () {
                return $this->splitPayments->transform(function($splitPayment){
                    return $splitPayment->toShowApi();
                });
            })
        ];
        $arr = $this->mergeArray(parent::toArray($request), $arr);
        return $arr;
    }
}
