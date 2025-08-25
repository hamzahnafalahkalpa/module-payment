<?php

namespace Hanafalah\ModulePayment\Data;

use Hanafalah\LaravelSupport\Supports\Data;
use Hanafalah\ModulePayment\Contracts\Data\PaymentSummaryPropsData as DataPaymentSummaryPropsData;
use Hanafalah\ModuleTax\Contracts\Data\TotalTaxData;
use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Attributes\MapName;

class PaymentSummaryPropsData extends Data implements DataPaymentSummaryPropsData
{
    #[MapInputName('form')]
    #[MapName('form')]
    public ?array $form = null;

    #[MapInputName('total_tax')]
    #[MapName('total_tax')]
    public ?TotalTaxData $total_tax = null;

    #[MapInputName('props')]
    #[MapName('props')]
    public ?array $props = null;
}
