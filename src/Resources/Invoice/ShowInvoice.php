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
            'payment_summary'   => $this->relationValidation('paymentSummary', function () {
                $paymentSummary = $this->paymentSummary;
                return ShowPaymentSummary($paymentSummary);
            })
        ];
        $arr = $this->mergeArray(parent::toArray($request), $arr);

        return $arr;
    }
}
