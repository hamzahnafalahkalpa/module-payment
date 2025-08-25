<?php

namespace Hanafalah\ModulePayment\Contracts\Schemas;

use Hanafalah\ModulePayment\Contracts\Data\BillingDeferredData;
//use Hanafalah\ModulePayment\Contracts\Data\BillingDeferredUpdateData;
use Hanafalah\LaravelSupport\Contracts\Supports\DataManagement;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * @see \Hanafalah\ModulePayment\Schemas\BillingDeferred
 * @method mixed export(string $type)
 * @method self conditionals(mixed $conditionals)
 * @method array updateBillingDeferred(?BillingDeferredData $billing_deferred_dto = null)
 * @method Model prepareUpdateBillingDeferred(BillingDeferredData $billing_deferred_dto)
 * @method bool deleteBillingDeferred()
 * @method bool prepareDeleteBillingDeferred(? array $attributes = null)
 * @method mixed getBillingDeferred()
 * @method ?Model prepareShowBillingDeferred(?Model $model = null, ?array $attributes = null)
 * @method array showBillingDeferred(?Model $model = null)
 * @method Collection prepareViewBillingDeferredList()
 * @method array viewBillingDeferredList()
 * @method LengthAwarePaginator prepareViewBillingDeferredPaginate(PaginateData $paginate_dto)
 * @method array viewBillingDeferredPaginate(?PaginateData $paginate_dto = null)
 * @method array storeBillingDeferred(?BillingDeferredData $billing_deferred_dto = null)
 */
interface BillingDeferred extends Invoice
{
    public function prepareStoreBillingDeferred(BillingDeferredData $billing_deferred_dto): Model;
}