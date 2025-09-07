<?php

namespace Hanafalah\ModulePayment\Resources\Refund;

use Hanafalah\ModulePayment\Resources\BaseWalletTransaction\ViewBaseWalletTransaction;

class ViewRefund extends ViewBaseWalletTransaction
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
            'invoice' => $this->relationValidation('invoice',function(){
                return $this->invoice->toViewApi()->resolve();
            },$this->prop_invoice),
            'refund_items' => $this->relationValidation('refundItems', function () {
                return $this->refundItems->map(function ($refundItem) {
                    return $refundItem->toViewApi();
                });
            })
        ];
        $arr = $this->mergeArray(parent::toArray($request),$arr);
        return $arr;
    }
}
