<?php

namespace Hanafalah\ModulePayment\Resources\PaymentDetail;

class ShowPaymentDetail extends ViewPaymentDetail
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
            'transaction_item' => $this->relationValidation('transactionItem', function () {
                return $this->transactionItem->toShowApi();
            }),
            'payment_history'  => $this->relationValidation("paymentHistory", function () {
                return $this->paymentHistory->toShowApi();
            })
        ];
        $arr = $this->mergeArray(parent::toArray($request), $arr);
        return $arr;
    }
}
