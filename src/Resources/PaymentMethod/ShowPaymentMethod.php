<?php

namespace Hanafalah\ModulePayment\Resources\PaymentMethod;

use Hanafalah\ModulePayment\Resources\FinanceStuff\ShowFinanceStuff;

class ShowPaymentMethod extends ViewPaymentMethod
{

    /**
     * Transform the resource into an array.
     * 
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray(\Illuminate\Http\Request $request): array
    {
        $arr = [];
        $show = $this->resolveNow(new ShowFinanceStuff($this));
        $arr = $this->mergeArray(parent::toArray($request),$show,$arr);
        return $arr;
    }
}
