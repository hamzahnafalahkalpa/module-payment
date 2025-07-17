<?php

namespace Hanafalah\ModulePayment\Supports;

use Hanafalah\LaravelSupport\Supports\PackageManagement;

class BaseModulePayment extends PackageManagement
{
    /** @var array */
    protected $__module_payment_config = [];

    /**
     * A description of the entire PHP function.
     *
     * @param Container $app The Container instance
     * @throws Exception description of exception
     * @return void
     */
    public function __construct()
    {
        $this->setConfig('module-payment', $this->__module_payment_config);
    }
}
