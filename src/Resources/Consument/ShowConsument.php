<?php

namespace Hanafalah\ModulePayment\Resources\Consument;

class ShowConsument extends ViewConsument
{
    public function toArray(\Illuminate\Http\Request $request): array
    {
        $arr = [
            'reference'  => $this->relationValidation('reference', function () {
                return $this->reference->toShowApi()->resolve();
            })
        ];
        $arr = $this->mergeArray(parent::toArray($request), $arr);

        return $arr;
    }
}
