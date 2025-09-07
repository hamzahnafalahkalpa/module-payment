<?php

namespace Hanafalah\ModulePayment\Resources\PaymentHistoryDetail;

use Hanafalah\ModulePayment\Resources\PaymentDetail\ShowPaymentDetail;

class ShowPaymentHistoryDetail extends ViewPaymentHistoryDetail
{
  /**
   * Transform the resource into an array.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
   */
  public function toArray(\Illuminate\Http\Request $request): array
  {
    $arr = [];
    $show = $this->resolveNow(new ShowPaymentDetail($this));
    $arr = $this->mergeArray(parent::toArray($request),$show,$arr);
    return $arr;
  }
}
