<?php

namespace Hanafalah\ModulePayment\Resources\PaymentHasModel;

use Hanafalah\LaravelSupport\Resources\ApiResource;

class ViewPaymentHasModel extends ApiResource
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
      'id' => $this->id,
      'payment_id' => $this->payment_id,
      'payment_type' => $this->payment_type,
      'model_type' => $this->model_type,
      'model_id' => $this->model_id
    ];
    return $arr;
  }
}
