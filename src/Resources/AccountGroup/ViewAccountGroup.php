<?php

namespace Hanafalah\ModulePayment\Resources\AccountGroup;

use Hanafalah\ModulePayment\Resources\Coa\ViewCoa;

class ViewAccountGroup extends ViewCoa
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
      'coas' => $this->relationValidation('coas', function(){
          return $this->coas->transform(function($coa){
              return $coa->toShowApi();
          });
      })
    ];
    $arr = $this->mergeArray(parent::toArray($request),$arr);
    return $arr;
  }
}
