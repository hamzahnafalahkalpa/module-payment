<?php

namespace Hanafalah\ModulePayment\Data;

use Hanafalah\LaravelSupport\Supports\Data;
use Hanafalah\ModulePayment\Contracts\Data\PaymentMethodData as DataPaymentMethodData;
use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Attributes\MapName;

class PaymentMethodData extends Data implements DataPaymentMethodData
{
    #[MapInputName('id')]
    #[MapName('id')]
    public mixed $id = null;

    #[MapInputName('name')]
    #[MapName('name')]
    public string $name;

    #[MapInputName('flag')]
    #[MapName('flag')]
    public string $flag;

    #[MapInputName('props')]
    #[MapName('props')]
    public ?array $props = [];
}
