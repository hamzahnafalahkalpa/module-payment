<?php

namespace Hanafalah\ModulePayment\Schemas;

use Hanafalah\ModulePayment\Contracts\Data\DeferredPaymentData;
use Hanafalah\ModulePayment\Contracts\Data\InvoiceData;
use Hanafalah\ModulePayment\Contracts\Schemas\DeferredPayment as ContractsDeferredPayment;
use Illuminate\Database\Eloquent\Model;

class DeferredPayment extends Invoice implements ContractsDeferredPayment
{
    protected string $__entity = 'DeferredPayment';
    public $deferred_payment_model;

    public function prepareStoreDeferredPayment(DeferredPaymentData|InvoiceData $deferred_payment_dto): Model{
        return $this->deferred_payment_model = parent::prepareStoreInvoice($deferred_payment_dto);
    }
}
