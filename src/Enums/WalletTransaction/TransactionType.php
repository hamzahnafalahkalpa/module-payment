<?php

namespace Hanafalah\ModulePayment\Enums\WalletTransaction;

enum TransactionType: string
{
    case DEBIT   = 'DEBIT';
    case CREDIT  = 'CREDIT';
}
