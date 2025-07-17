<?php

namespace Hanafalah\ModulePayment\Contracts\Schemas;

use Hanafalah\LaravelSupport\Contracts\Schemas\Unicode;
use Hanafalah\ModulePayment\Contracts\Data\FinanceStuffData;
//use Hanafalah\ModulePayment\Contracts\Data\FinanceStuffUpdateData;
use Hanafalah\LaravelSupport\Contracts\Supports\DataManagement;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * @see \Hanafalah\ModulePayment\Schemas\FinanceStuff
 * @method self setParamLogic(string $logic, bool $search_value = false, ?array $optionals = [])
 * @method self conditionals(mixed $conditionals)
 * @method array updateFinanceStuff(?FinanceStuffData $finance_stuff_dto = null)
 * @method Model prepareUpdateFinanceStuff(FinanceStuffData $finance_stuff_dto)
 * @method bool deleteFinanceStuff()
 * @method bool prepareDeleteFinanceStuff(? array $attributes = null)
 * @method mixed getFinanceStuff()
 * @method ?Model prepareShowFinanceStuff(?Model $model = null, ?array $attributes = null)
 * @method array showFinanceStuff(?Model $model = null)
 * @method Collection prepareViewFinanceStuffList()
 * @method array viewFinanceStuffList()
 * @method LengthAwarePaginator prepareViewFinanceStuffPaginate(PaginateData $paginate_dto)
 * @method array viewFinanceStuffPaginate(?PaginateData $paginate_dto = null)
 * @method array storeFinanceStuff(?FinanceStuffData $finance_stuff_dto = null);
 */
interface FinanceStuff extends Unicode
{
    public function prepareStoreFinanceStuff(FinanceStuffData $finance_stuff_dto): Model;
    public function financeStuff(mixed $conditionals = null): Builder;

}