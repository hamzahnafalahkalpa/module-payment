<?php

namespace Hanafalah\ModulePayment\Resources\Consument;

use Hanafalah\LaravelSupport\Resources\ApiResource;

class ViewConsument extends ApiResource
{
    public function toArray(\Illuminate\Http\Request $request): array
    {
        $arr = [
            'id'         => $this->id,
            'uuid'       => $this->uuid,
            'name'       => $this->name,
            'phone'      => $this->phone,
            'reference'  => $this->relationValidation('reference', function () {
                return $this->propsNil($this->reference->toViewApi()->resolve(),'consument');
            },$this->prop_reference),
            'created_at'  => $this->created_at,
            'updated_at'  => $this->updated_at
        ];


        return $arr;
    }
}
