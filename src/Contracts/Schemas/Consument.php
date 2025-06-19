<?php

namespace Hanafalah\ModulePayment\Contracts\Schemas;

use Illuminate\Database\Eloquent\Model;
use Hanafalah\LaravelSupport\Contracts\Supports\DataManagement;
use Hanafalah\ModulePayment\Contracts\Data\ConsumentData;

/**
 * @see \Hanafalah\ModulePayment\Schemas\Consument
 * @method self setParamLogic(string $logic, bool $search_value = false, ?array $optionals = [])
 * @method self conditionals(mixed $conditionals)
 * @method array updateConsument(?ConsumentData $consument_dto = null)
 * @method Model prepareUpdateConsument(ConsumentData $consument_dto)
 * @method bool deleteConsument()
 * @method bool prepareDeleteConsument(? array $attributes = null)
 * @method mixed getConsument()
 * @method ?Model prepareShowConsument(?Model $model = null, ?array $attributes = null)
 * @method array showConsument(?Model $model = null)
 * @method Collection prepareViewConsumentList()
 * @method array viewConsumentList()
 * @method LengthAwarePaginator prepareViewConsumentPaginate(PaginateData $paginate_dto)
 * @method array viewConsumentPaginate(?PaginateData $paginate_dto = null)
 * @method array storeConsument(?CoaTypeData $consument_dto = null)
 * @method Builder consument(mixed $conditionals = null)
 */
interface Consument extends DataManagement
{
    public function prepareStoreConsument(ConsumentData $consument_dto): Model;
}
