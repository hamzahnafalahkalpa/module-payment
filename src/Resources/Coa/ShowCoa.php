<?php

namespace Hanafalah\ModulePayment\Resources\Coa;

class ShowCoa extends ViewCoa
{

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray(\Illuminate\Http\Request $request): array
    {
        $arr = [
            'childs' => $this->relationValidation('childs', function(){
                return $this->childs->transform(function($child){
                    return $child->toShowApi();
                });
            })
        ];
        $arr = $this->mergeArray(parent::toArray($request), $arr);
        return $arr;
    }
}
