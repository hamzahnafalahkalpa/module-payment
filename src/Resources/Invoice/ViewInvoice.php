<?php

namespace Hanafalah\ModulePayment\Resources\Invoice;

use Hanafalah\LaravelSupport\Resources\ApiResource;

class ViewInvoice extends ApiResource
{
    public function toArray(\Illuminate\Http\Request $request): array
    {
        $arr = [
            'id' => $this->id,
            'invoice_code' => $this->invoice_code,
            'payment_summary' => $this->relationValidation('paymentSummary', function () {
                return $this->paymentSummary->toViewApi()->resolve();
            }),
            'payment_history' => $this->relationValidation('paymentHistory', function () {
                return $this->paymentHistory->toViewApi()->resolve();
            }),
            'author' => $this->relationValidation('author', function () {
                return $this->author->toViewApi()->resolve();
            }, $this->prop_author),
            'payer' => $this->relationValidation('payer', function () {
                return $this->payer->toViewApi()->resolve();
            }, $this->prop_payer),
            'billing' => $this->relationValidation('billing', function () {
                return $this->billing->toViewApi()->resolve();
            },$this->prop_billing),
            'debt' => $this->debt ?? 0,
            'paid' => $this->paid ?? 0,
            'paid_at' => $this->paid_at,
            'created_at' => $this->created_at,
        ];
        return $arr;
    }
}
