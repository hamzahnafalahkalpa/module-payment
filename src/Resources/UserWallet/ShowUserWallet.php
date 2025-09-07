<?php

namespace Hanafalah\ModulePayment\Resources\UserWallet;

class ShowUserWallet extends ViewUserWallet
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
      'verified_at' => $this->verified_at,
      'suspended_at' => $this->suspended_at,
      'status' => $this->status
    ];
    $arr = $this->mergeArray(parent::toArray($request),$arr);
    return $arr;
  }
}
