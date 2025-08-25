<?php

namespace Hanafalah\ModulePayment\Resources\Transaction;

use Hanafalah\ModuleTransaction\Resources\Transaction\ViewTransaction;

class ViewPosTransaction extends ViewTransaction
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
                return $this->paymentSummary->toViewApi()->resolve();
            })
        ];
        $arr = $this->mergeArray(parent::toArray($request), $arr);
        return $arr;
    }
}
