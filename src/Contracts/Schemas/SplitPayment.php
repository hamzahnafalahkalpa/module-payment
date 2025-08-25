<?php

namespace Hanafalah\ModulePayment\Contracts\Schemas;

use Hanafalah\LaravelSupport\Contracts\Supports\DataManagement;
use Hanafalah\ModulePayment\Contracts\Data\SplitPaymentData;
use Illuminate\Database\Eloquent\Model;

/**
 * @see \Hanafalah\ModulePayment\Schemas\SplitPayment
 * @method self setParamLogic(string $logic, bool $search_value = false, ?array $optionals = [])
 * @method self conditionals(mixed $conditionals)
 * @method mixed export(string $type)
 * @method bool deleteSplitPayment()
 * @method bool prepareDeleteSplitPayment(? array $attributes = null)
 * @method mixed getSplitPayment()
 * @method ?Model prepareShowSplitPayment(?Model $model = null, ?array $attributes = null)
 * @method array showSplitPayment(?Model $model = null)
 * @method Collection prepareViewSplitPaymentList()
 * @method array viewSplitPaymentList()
 * @method LengthAwarePaginator prepareViewSplitPaymentPaginate(PaginateData $paginate_dto)
 * @method array viewSplitPaymentPaginate(?PaginateData $paginate_dto = null)
 * @method array storeSplitPayment(?SplitPaymentData $split_payment_dto = null)
 */
interface SplitPayment extends DataManagement
{
    public function prepareStoreSplitPayment(SplitPaymentData $split_payment_dto): Model;
}
