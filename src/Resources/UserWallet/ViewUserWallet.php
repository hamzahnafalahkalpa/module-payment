<?php

namespace Hanafalah\ModulePayment\Resources\UserWallet;

use Hanafalah\LaravelSupport\Resources\ApiResource;

class ViewUserWallet extends ApiResource
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
      'user_wallet_code' => $this->user_wallet_code,
      'uuid' => $this->uuid,
      'wallet_id' => $this->wallet_id,
      'wallet' => $this->relationValidation('wallet',function(){
        return $this->wallet->toViewApi()->resolve();
      },$this->prop_wallet),
      'balance' => floatval($this->balance)
    ];
    return $arr;
  }
}
