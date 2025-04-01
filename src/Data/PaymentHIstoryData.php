<?php

namespace Hanafalah\ModulePayment\Data;

use Hanafalah\LaravelSupport\Supports\Data;
use Hanafalah\ModulePayment\Contracts\Data\PaymentHistoryData as DataPaymentHistoryData;

class PaymentHistoryData extends Data implements DataPaymentHistoryData
{
    public function __construct(
        public mixed $id,
        public mixed $parent_id,
        public mixed $transaction_id,
        public ?string $reference_type,
        public mixed $reference_id,
        public int $amount = 0,
        public int $cogs = 0,
        public int $discount = 0,
        public int $debt = 0,
        public int $refund = 0,
        public int $tax = 0,
        public int $additional = 0,
        ...$args
    ) {}
}
