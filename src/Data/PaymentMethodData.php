<?php

namespace Hanafalah\ModulePayment\Data;

use Hanafalah\ModulePayment\Contracts\Data\PaymentMethodData as DataPaymentMethodData;
use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Attributes\MapName;
use Spatie\LaravelData\Attributes\Validation\In;

class PaymentMethodData extends FinanceStuffData implements DataPaymentMethodData
{
    #[MapInputName('flag')]
    #[MapName('flag')]
    #[In('TUNAI','NON TUNAI')]
    public string $flag;

    public static function before(array &$attributes){
        $attributes['flag'] ??= 'PaymentMethod';
        parent::before($attributes);
    }
}
