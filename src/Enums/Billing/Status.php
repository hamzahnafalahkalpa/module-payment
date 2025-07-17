<?php

namespace Hanafalah\ModulePayment\Enums\Billing;

enum Status: string
{
    case DRAFT     = 'DRAFT';
    case REPORTED  = 'REPORTED';
    case CANCELLED = 'CANCELLED';
}
