<?php

namespace Hanafalah\ModulePayment\Resources\SplitPayment;

use Hanafalah\LaravelSupport\Resources\ApiResource;

class ViewSplitPayment extends ApiResource
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
            'id'                => $this->id,
            'split_payment_code'   => $this->split_payment_code,
            'payment_method'    => $this->payment_method,
            'paid'        => $this->paid,
            'note'              => $this->note,
            'payer'             => $this->relationValidation('payer', function () {
                return $this->payer->toViewApi()->resolve();
            }),
            'payment_summary'   => $this->relationValidation('paymentSummary', function () {
                return $this->paymentSummary->toViewApi()->resolve();
            }),
            'payment_history' => $this->relationValidation('paymentHistory', function () {
                return $this->paymentHistory->toViewApi()->resolve();
            }),
            'payment_details' => $this->getPaymentDetails(),
            // 'payment_details' => $this->relationValidation('paymentHistoryDetails',function(){
            //     return $this->paymentHistoryDetails->transform(function($payment_history){
            //         return $payment_history->toViewApi()->resolve();
            //     });
            // }),
            // 'payment_history_details' => $this->relationValidation('paymentHistoryDetails',function(){
            //     return $this->paymentHistoryDetails->transform(function($payment_history){
            //         return $payment_history->toViewApi()->resolve();
            //     });
            // }),
            'created_at'      => $this->created_at,
        ];

        return $arr;
    }
}
