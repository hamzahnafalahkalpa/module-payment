<?php

namespace Hanafalah\ModulePayment\Resources\Refund;

use Hanafalah\ModulePayment\Resources\BaseWalletTransaction\ShowBaseWalletTransaction;

class ShowRefund extends ViewRefund
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
            'refund_items' => $this->relationValidation('refundItems', function () {
                return $this->refundItems->transform(function ($refundItem) {
                    return $refundItem->toShowApi();
                });
            })
        ];

        $show = $this->resolveNow(new ShowBaseWalletTransaction($this));
        $arr = $this->mergeArray(parent::toArray($request), $show, $arr);
        return $arr;
    }
}
