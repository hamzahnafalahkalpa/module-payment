<?php

namespace Hanafalah\ModulePayment\Resources\WalletTransaction;

class ShowWalletTransaction extends ViewWalletTransaction
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
      'reference_type' => $this->reference_type,
      'reference' => $this->relationValidation('reference',function(){
          return $this->reference->toViewApi()->resolve();
      },$this->prop_reference),
      'author_type' => $this->author_type,
      'author_id'   => $this->author_id
    ];
    $arr = $this->mergeArray(parent::toArray($request),$arr);
    return $arr;
  }
}
