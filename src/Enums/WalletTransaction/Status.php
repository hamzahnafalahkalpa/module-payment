<?php

namespace Hanafalah\ModulePayment\Enums\WalletTransaction;

enum Status: string
{
    case DRAFT     = 'DRAFT';
    case PENDING   = 'PENDING';
    case SUCCESS   = 'SUCCESS';
    case FAILED    = 'FAILED';
}
