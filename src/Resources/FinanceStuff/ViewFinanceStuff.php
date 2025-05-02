<?php

namespace Hanafalah\ModulePayment\Resources\FinanceStuff;

use Hanafalah\LaravelSupport\Resources\ApiResource;

class ViewFinanceStuff extends ApiResource
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
      'id'         => $this->id,
      'parent_id'  => $this->parent_id,
      'name'       => $this->name,
      'flag'       => $this->flag,
      'created_at' => $this->created_at,
      'updated_at' => $this->updated_at,
      'childs'     => $this->relationValidation('childs',function(){
        return $this->childs->transform(function($child){
          return $child->toViewApi();
        });
      })
    ];
    return $arr;
  }
}
