<?php

namespace Hanafalah\ModulePayment\Resources\Channel;

use Hanafalah\ModulePayment\Resources\PaymentMethod\ViewPaymentMethod;

class ViewChannel extends ViewPaymentMethod
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
    $arr = $this->mergeArray(parent::toArray($request),$arr);
    return $arr;
  }
}
