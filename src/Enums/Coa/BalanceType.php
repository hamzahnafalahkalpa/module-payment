<?php

namespace Hanafalah\ModulePayment\Enums\Coa;

enum BalanceType: string
{
    case DEBIT   = 'DEBIT';
    case CREDIT  = 'CREDIT';
    case MIXED   = 'MIXED';
}
