<?php

namespace Hanafalah\ModulePayment\Resources\PaymentDetail;

use Hanafalah\LaravelSupport\Resources\ApiResource;

class ViewPaymentDetail extends ApiResource
{
    public function toArray(\Illuminate\Http\Request $request): array
    {
        $arr = [
            'id'                => $this->id,
            'qty'               => $this->qty,
            'amount'            => $this->amount,
            'price'             => $this->price,
            'debt'              => $this->debt,
            'tax'               => $this->tax,
            'additional'        => $this->additional,
            'discount'          => $this->discount,
            'paid'              => $this->paid,
            'note'              => $this->note,
            'created_at'        => $this->created_at,
            'transaction_item_type' => $this->transaciton_item_type,
            'transaction_item_id' => $this->transaciton_item_id,
            'created_at'        => $this->created_at,
            'transaction_item'  => $this->relationValidation('transactionItem', function () {
                return $this->transactionItem->toViewApi();
            }),
            'payment_history'  => $this->relationValidation("paymentHistory", function () {
                return $this->paymentHistory->toViewApi();
            })
        ];

        if (isset($this->pre_debt)) {
            $arr = $this->mergeArray($arr, [
                "pre_debt"       => $this->pre_debt,
                "pre_additional" => $this->pre_additional,
                "pre_discount"   => $this->pre_discount,
            ]);
        }


        return $arr;
    }
}
