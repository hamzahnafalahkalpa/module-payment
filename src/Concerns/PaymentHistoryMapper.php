<?php

namespace Hanafalah\ModulePayment\Concerns;

use Hanafalah\ModulePayment\Data\PaymentHistoryDTO;

trait PaymentHistoryMapper
{
    protected function storePaymentHistoryMapper(?array $attributes = null): PaymentHistoryDTO
    {
        $valid_attributes = isset($attributes['id']) || (
            isset($attributes['transaction_id']) && isset($attributes['reference_type']) && isset($attributes['reference_id'])
        );
        if (!$valid_attributes) throw new \Exception('Payment history not valid');

        return new PaymentHistoryDTO(
            $attributes['id'] ?? null,
            $attributes['parent_id'] ?? null,
            $attributes['transaction_id'] ?? null,
            $attributes['reference_type'] ?? null,
            $attributes['reference_id'] ?? null,
            $attributes['amount'] ?? 0,
            $attributes['cogs'] ?? 0,
            $attributes['discount'] ?? 0,
            $attributes['debt'] ?? 0,
            $attributes['tax'] ?? 0,
            $attributes['additional'] ?? 0
        );
    }
}
