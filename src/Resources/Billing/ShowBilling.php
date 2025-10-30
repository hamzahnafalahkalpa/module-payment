<?php

namespace Hanafalah\ModulePayment\Resources\Billing;

class ShowBilling extends ViewBilling
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
            'author'  => $this->relationValidation('author', function () {
                return $this->author->toShowApi()->resolve();
            }, $this->prop_author),
            'invoices'  => $this->relationValidation('invoices', function () {
                return $this->invoices->transform(function($invoice){
                    return $this->propNil($invoice->toShowApi(),'billing');
                });
            })
        ];
        $arr = $this->mergeArray(parent::toArray($request), $arr);

        return $arr;
    }
}
