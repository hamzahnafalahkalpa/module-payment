<?php

namespace Hanafalah\ModulePayment\Contracts\Schemas;

use Hanafalah\LaravelSupport\Contracts\Supports\DataManagement;
use Hanafalah\ModulePayment\Contracts\Data\SplitBillData;
use Illuminate\Database\Eloquent\Model;

/**
 * @see \Hanafalah\ModulePayment\Schemas\SplitBill
 * @method self setParamLogic(string $logic, bool $search_value = false, ?array $optionals = [])
 * @method self conditionals(mixed $conditionals)
 * @method mixed export(string $type)
 * @method bool deleteSplitBill()
 * @method bool prepareDeleteSplitBill(? array $attributes = null)
 * @method mixed getSplitBill()
 * @method ?Model prepareShowSplitBill(?Model $model = null, ?array $attributes = null)
 * @method array showSplitBill(?Model $model = null)
 * @method Collection prepareViewSplitBillList()
 * @method array viewSplitBillList()
 * @method LengthAwarePaginator prepareViewSplitBillPaginate(PaginateData $paginate_dto)
 * @method array viewSplitBillPaginate(?PaginateData $paginate_dto = null)
 * @method array storeSplitBill(?SplitBillData $split_bill_dto = null)
 */
interface SplitBill extends DataManagement
{
    public function prepareStoreSplitBill(SplitBillData $split_bill_dto): Model;
}
