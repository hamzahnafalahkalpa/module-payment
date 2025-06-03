<?php

namespace Hanafalah\ModulePayment\Resources\ComponentDetail;

use Hanafalah\LaravelSupport\Resources\ApiResource;

class ViewComponentDetail extends ApiResource
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
            'name' => $this->flag
        ];

        return $arr;
    }
}
