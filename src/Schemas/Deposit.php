<?php

namespace Hanafalah\ModulePayment\Schemas;

use Hanafalah\LaravelSupport\Supports\PackageManagement;
use Hanafalah\ModulePayment\Contracts\Schemas\Deposit as ContractsDeposit;

class Deposit extends PackageManagement implements ContractsDeposit
{
    protected string $__entity = 'Deposit';
    public static $deposit_model;
}
