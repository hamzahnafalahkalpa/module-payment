<?php

namespace Hanafalah\ModulePayment\Data;

use Hanafalah\ModulePayment\Contracts\Data\PaymentHasModelData as DataPaymentHasModelData;
use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Attributes\MapName;

class PaymentHasModelData extends PaymentSummaryData implements DataPaymentHasModelData
{
    #[MapInputName('id')]
    #[MapName('id')]
    public mixed $id = null;

    #[MapInputName('payment_type')]
    #[MapName('payment_type')]
    public ?string $payment_type = null;

    #[MapInputName('payment_id')]
    #[MapName('payment_id')]
    public mixed $payment_id = null;

    #[MapInputName('model_type')]
    #[MapName('model_type')]
    public ?string $model_type = null;

    #[MapInputName('model_id')]
    #[MapName('model_id')]
    public mixed $model_id = null;
}
