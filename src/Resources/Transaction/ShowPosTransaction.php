<?php

namespace Hanafalah\ModulePayment\Resources\Transaction;

use Hanafalah\ModuleTransaction\Resources\Transaction\ShowTransaction;

class ShowPosTransaction extends ViewPosTransaction
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
            'billing' => $this->relationValidation('billing', function () {
                return $this->propNil($this->billing->toShowApi()->resolve(),'has_transaction');
            }),
            'payment_summary' => $this->relationValidation('paymentSummary', function () {
                return $this->paymentSummary->toShowApi();
            })
        ];
        $show = $this->resolveNow(new ShowTransaction($this));
        $arr = $this->mergeArray(parent::toArray($request),$show, $arr);
        return $arr;
    }
}
