<?php

namespace Hanafalah\ModulePayment\Contracts\Schemas;

use Hanafalah\ModulePayment\Contracts\Data\DeferredPaymentData;
//use Hanafalah\ModulePayment\Contracts\Data\DeferredPaymentUpdateData;
use Hanafalah\LaravelSupport\Contracts\Supports\DataManagement;
use Hanafalah\ModulePayment\Contracts\Data\InvoiceData;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * @see \Hanafalah\ModulePayment\Schemas\DeferredPayment
 * @method mixed export(string $type)
 * @method self conditionals(mixed $conditionals)
 * @method array updateDeferredPayment(?DeferredPaymentData $deferred_payment_dto = null)
 * @method Model prepareUpdateDeferredPayment(DeferredPaymentData $deferred_payment_dto)
 * @method bool deleteDeferredPayment()
 * @method bool prepareDeleteDeferredPayment(? array $attributes = null)
 * @method mixed getDeferredPayment()
 * @method ?Model prepareShowDeferredPayment(?Model $model = null, ?array $attributes = null)
 * @method array showDeferredPayment(?Model $model = null)
 * @method Collection prepareViewDeferredPaymentList()
 * @method array viewDeferredPaymentList()
 * @method LengthAwarePaginator prepareViewDeferredPaymentPaginate(PaginateData $paginate_dto)
 * @method array viewDeferredPaymentPaginate(?PaginateData $paginate_dto = null)
 * @method array storeDeferredPayment(?DeferredPaymentData $deferred_payment_dto = null)
 */
interface DeferredPayment extends Invoice
{
    public function prepareStoreDeferredPayment(DeferredPaymentData|InvoiceData $deferred_payment_dto): Model;
}