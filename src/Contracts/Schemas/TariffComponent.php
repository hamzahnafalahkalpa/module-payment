<?php

namespace Hanafalah\ModulePayment\Contracts\Schemas;

use Hanafalah\LaravelSupport\Contracts\Supports\DataManagement;

/**
 * @see \Hanafalah\ModulePayment\Schemas\TariffComponent
 * @method self setParamLogic(string $logic, bool $search_value = false, ?array $optionals = [])
 * @method self conditionals(mixed $conditionals)
 * @method array storeTariffComponent(?TariffComponentData $tariff_component_dto = null)
 * @method bool deleteTariffComponent()
 * @method bool prepareDeleteTariffComponent(? array $attributes = null)
 * @method mixed getTariffComponent()
 * @method ?Model prepareShowTariffComponent(?Model $model = null, ?array $attributes = null)
 * @method array showTariffComponent(?Model $model = null)
 * @method array viewTariffComponentList()
 * @method Collection prepareViewTariffComponentList(? array $attributes = null)
 * @method LengthAwarePaginator prepareViewTariffComponentPaginate(PaginateData $paginate_dto)
 * @method array viewTariffComponentPaginate(?PaginateData $paginate_dto = null)
 * @method Builder function tariffComponent(mixed $conditionals = null)
 */
interface TariffComponent extends DataManagement
{
}
