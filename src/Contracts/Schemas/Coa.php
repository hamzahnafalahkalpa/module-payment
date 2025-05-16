<?php

namespace Hanafalah\ModulePayment\Contracts\Schemas;

use Illuminate\Database\Eloquent\Model;
use Hanafalah\LaravelSupport\Contracts\Supports\DataManagement;
use Hanafalah\ModulePayment\Contracts\Data\CoaData;

/**
 * @see \Hanafalah\ModulePayment\Schemas\Coa
 * @method bool deleteCoa()
 * @method bool prepareDeleteCoa(? array $attributes = null)
 * @method mixed getCoa()
 * @method ?Model prepareShowCoa(?Model $model = null, ?array $attributes = null)
 * @method array showCoa(?Model $model = null)
 * @method Collection prepareViewCoaList()
 * @method array viewCoaList()
 * @method LengthAwarePaginator prepareViewCoaPaginate(PaginateData $paginate_dto)
 * @method array viewCoaPaginate(?PaginateData $paginate_dto = null)
 * @method array storeCoa(?CoaData $funding_dto = null)
 * @method Builder coa(mixed $conditionals = null)
 */
interface Coa extends DataManagement
{
    public function prepareStoreCoa(CoaData $Coa_dto): Model;
}
