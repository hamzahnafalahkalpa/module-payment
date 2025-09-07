<?php

namespace Hanafalah\ModulePayment\Resources\Channel;

use Hanafalah\ModulePayment\Resources\PaymentMethod\ShowPaymentMethod;

class ShowChannel extends ViewChannel
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
    $show = $this->resolveNow(new ShowPaymentMethod($this));
    $arr = $this->mergeArray(parent::toArray($request),$show,$arr);
    return $arr;
  }
}
