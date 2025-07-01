<?php

namespace Hanafalah\ModulePayment\Resources\TariffComponent;

use Hanafalah\LaravelSupport\Resources\ApiResource;

class ViewTariffComponent extends ApiResource
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
            'id'   => $this->id,
            'name' => $this->name,
            'component_details' => $this->relationValidation('componentDetails', function () {
                return $this->componentDetails->transform(function ($component) {
                    return $component->toViewApi()->resolve();
                });
            }),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ];
        if (isset($this->price)) {
            $arr['price'] = $this->price;
        }

        return $arr;
    }
}
