<?php

namespace Hanafalah\ModulePayment\Data;

use Carbon\Carbo;
use Hanafalah\ModulePayment\Contracts\Data\BillingData;
use Hanafalah\ModulePayment\Contracts\Data\PosTransactionData as DataPosTransactionData;
use Hanafalah\ModuleTransaction\Data\TransactionData as DataTransactionData;
use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Attributes\MapName;

class PosTransactionData extends DataTransactionData implements DataPosTransactionData
{
    #[MapInputName('billing')]
    #[MapName('billing')]      
    public ?BillingData $billing = null;
}
