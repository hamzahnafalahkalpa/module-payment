<?php

namespace Hanafalah\ModulePayment\Resources\PaymentHistory;

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
      'refund'           => $this->refund,
      'additional'       => $this->additional,
      'tax'              => $this->tax,
      'total_tax'        => $this->total_tax,
      'transaction'      => $this->relationValidation('transaction', function () {
          return $this->transaction->toShowApi()->resolve();
      },$this->prop_transaction),
      'note'             => $this->note,
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
      // 'payment_summaries' => $this->relationValidation('paymentSummaries', function () {
      //     return $this->paymentSummaries->transform(function ($paymentSummary) {
      //         return new static($paymentSummary);
      //     });
      // }),
      'form' => $this->form
    ];

    // if ($this->relationLoaded('recursiveChilds')) {
    //     $arr['childs'] = $this->relationValidation('recursiveChilds', function () {
    //         return $this->recursiveChilds->transform(function ($child) {
    //             return new static($child);
    //         });
    //     });
    // }
    $arr = $this->mergeArray(parent::toArray($request),$arr);
    return $arr;
  }
}
