<?php

namespace Hanafalah\ModulePayment\Contracts\Schemas;

use Hanafalah\ModulePayment\Contracts\Data\CoaTypeData;
//use Hanafalah\ModulePayment\Contracts\Data\CoaTypeUpdateData;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * @see \Hanafalah\ModulePayment\Schemas\CoaType
 * @method self conditionals(mixed $conditionals)
 * @method array updateCoaType(?CoaTypeData $coa_type_dto = null)
 * @method Model prepareUpdateCoaType(CoaTypeData $coa_type_dto)
 * @method bool deleteCoaType()
 * @method bool prepareDeleteCoaType(? array $attributes = null)
 * @method mixed getCoaType()
 * @method ?Model prepareShowCoaType(?Model $model = null, ?array $attributes = null)
 * @method array showCoaType(?Model $model = null)
 * @method Collection prepareViewCoaTypeList()
 * @method array viewCoaTypeList()
 * @method LengthAwarePaginator prepareViewCoaTypePaginate(PaginateData $paginate_dto)
 * @method array viewCoaTypePaginate(?PaginateData $paginate_dto = null)
 * @method array storeCoaType(?CoaTypeData $coa_type_dto = null);
 */

interface CoaType extends FinanceStuff
{
    public function prepareStoreCoaType(CoaTypeData $coa_type_dto): Model;
    public function coaType(mixed $conditionals = null): Builder;
}