<?php

namespace Hanafalah\ModulePayment\Data;

use Hanafalah\ModulePayment\Contracts\Data\PosTransactionItemData as DataPosTransactionItemData;
use Hanafalah\ModuleTransaction\Data\TransactionItemData;
use Spatie\LaravelData\Attributes\MapInputName;
class PosTransactionItemData extends TransactionItemData implements DataPosTransactionItemData
{
}