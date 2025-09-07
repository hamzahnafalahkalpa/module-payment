<?php

namespace Hanafalah\ModulePayment\Resources\WalletTransaction;

use Hanafalah\LaravelSupport\Resources\ApiResource;

class ViewWalletTransaction extends ApiResource
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
        'name' => $this->name,
        'wallet_id' => $this->wallet_id,
        'user_wallet_id' => $this->user_wallet_id,
        'user_wallet' => $this->relationValidation('userWallet',function(){
          return $this->userWallet->toViewApi()->resolve();
        },$this->prop_user_wallet),
        'consument_type' => $this->consument_type,
        'consument'      => $this->relationValidation('consument',function(){
          return $this->consument->toViewApi()->resolve();
        },$this->prop_consument),        
        'previous_balance' => $this->previous_balance,
        'current_balance' => $this->current_balance,
        'nominal' => $this->nominal,
        'created_at' => $this->created_at,
        'updated_at' => $this->updated_at
    ];
    return $arr;
  }
}
