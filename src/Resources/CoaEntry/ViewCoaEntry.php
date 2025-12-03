<?php

namespace Hanafalah\ModulePayment\Resources\CoaEntry;

use Hanafalah\LaravelSupport\Resources\ApiResource;

class ViewCoaEntry extends ApiResource
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
      'id'           => $this->id,
      'coa_id'       => $this->coa_id,
      'coa'          => $this->prop_coa,
      'debit'        => $this->debit,
      'credit'       => $this->credit
    ];
    return $arr;
  }
}
