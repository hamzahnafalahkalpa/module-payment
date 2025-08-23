<?php

namespace Hanafalah\ModulePayment\Contracts\Schemas;

use Hanafalah\LaravelSupport\Contracts\Supports\DataManagement;
use Hanafalah\ModulePayment\Contracts\Data\BillingData;
use Illuminate\Database\Eloquent\Model;

/**
 * @see \Hanafalah\ModulePayment\Schemas\Billing
 * @method self setParamLogic(string $logic, bool $search_value = false, ?array $optionals = [])
 * @method self conditionals(mixed $conditionals)
 * @method mixed export(string $type)
 * @method bool deleteBilling()
 * @method bool prepareDeleteBilling(? array $attributes = null)
 * @method mixed getBilling()
 * @method ?Model prepareShowBilling(?Model $model = null, ?array $attributes = null)
 * @method array showBilling(?Model $model = null)
 * @method Collection prepareViewBillingList()
 * @method array viewBillingList()
 * @method LengthAwarePaginator prepareViewBillingPaginate(PaginateData $paginate_dto)
 * @method array viewBillingPaginate(?PaginateData $paginate_dto = null)
 * @method array storeBilling(?BillingData $billing_dto = null)
 */
interface Billing extends DataManagement
{
    public function prepareStoreBilling(BillingData $billing_dto): Model;
}
