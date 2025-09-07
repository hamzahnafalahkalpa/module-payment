<?php

namespace Hanafalah\ModulePayment\Data;

use Hanafalah\LaravelSupport\Supports\Data;
use Hanafalah\ModulePayment\Contracts\Data\BaseWalletTransactionPropsData as DataBaseWalletTransactionPropsData;
use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Attributes\MapName;

class BaseWalletTransactionPropsData extends Data implements DataBaseWalletTransactionPropsData
{
    #[MapInputName('form')]
    #[MapName('form')]
    public ?array $form = null;

    #[MapInputName('props')]
    #[MapName('props')]
    public ?array $props = null;
}