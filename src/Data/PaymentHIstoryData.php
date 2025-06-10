<?php

namespace Hanafalah\ModulePayment\Data;

use Hanafalah\LaravelSupport\Supports\Data;
use Hanafalah\ModulePayment\Contracts\Data\PaymentHistoryData as DataPaymentHistoryData;
use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Attributes\MapName;

class PaymentHistoryData extends Data implements DataPaymentHistoryData
{
    #[MapInputName('id')]
    #[MapName('id')]
    public mixed $id = null;
    
    #[MapInputName('parent_id')]
    #[MapName('parent_id')]
    public mixed $parent_id = null;
    
    #[MapInputName('transaction_id')]
    #[MapName('transaction_id')]
    public mixed $transaction_id;
    
    #[MapInputName('$reference_type')]
    #[MapName('$reference_type')]
    public ?string $reference_type;
    
    #[MapInputName('reference_id')]
    #[MapName('reference_id')]
    public mixed $reference_id;
    
    #[MapInputName('amount')]
    #[MapName('amount')]
    public int $amount = 0;
    
    #[MapInputName('cogs')]
    #[MapName('cogs')]
    public int $cogs = 0;
    
    #[MapInputName('discount')]
    #[MapName('discount')]
    public int $discount = 0;
    
    #[MapInputName('debt')]
    #[MapName('debt')]
    public int $debt = 0;
    
    #[MapInputName('refund')]
    #[MapName('refund')]
    public int $refund = 0;
    
    #[MapInputName('tax')]
    #[MapName('tax')]
    public int $tax = 0;
    
    #[MapInputName('additional')]
    #[MapName('additional')]
    public int $additional = 0;

    #[MapInputName('props')]
    #[MapName('props')]
    public ?array $props = [];
}
