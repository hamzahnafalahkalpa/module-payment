<?php

namespace Hanafalah\ModulePayment\Enums\Bank;

enum Flag: string
{
    case TUNAI     = 'TUNAI';
    case BILLED    = 'BILLED';
    case NON_TUNAI = 'NON TUNAI';
}
