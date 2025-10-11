<?php

namespace Hanafalah\ModulePayment\Resources\PaymentHistory;

use Hanafalah\ModulePayment\Resources\PaymentSummary\ShowPaymentSummary;

class ShowPaymentHistory extends ViewPaymentHistory
{
  /**
   * Transform the resource into an array.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
   */
  public function toArray(\Illuminate\Http\Request $request): array
  {
    $arr = [
      'payment_history_details'  => $this->relationValidation('paymentHistoryDetails', function () {
          return $this->paymentHistoryDetails->transform(function ($paymentDetail) {
              return $paymentDetail->toShowApi();
          });
      }),
      'childs' => $this->relationValidation('childs', function () {
          return $this->childs->transform(function ($child) {
              return $child->toShowApi();
          });
      }),
      'form' => $this->form
    ];
    $show = $this->resolveNow(new ShowPaymentSummary($this));
    $arr = $this->mergeArray(parent::toArray($request),$show,$arr);
    return $arr;
  }
}
