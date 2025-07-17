<?php

namespace Hanafalah\ModulePayment\Contracts\Schemas;

use Hanafalah\LaravelSupport\Contracts\Supports\DataManagement;

/**
 * @see \Hanafalah\ModulePayment\Schemas\ComponentDetail
 * @method self setParamLogic(string $logic, bool $search_value = false, ?array $optionals = [])
 * @method self conditionals(mixed $conditionals)
 * @method array storeComponentDetail(?ComponentDetailData $component_detail_dto = null)
 * @method bool deleteComponentDetail()
 * @method bool prepareDeleteComponentDetail(? array $attributes = null)
 * @method mixed getComponentDetail()
 * @method ?Model prepareShowComponentDetail(?Model $model = null, ?array $attributes = null)
 * @method array showComponentDetail(?Model $model = null)
 * @method array viewComponentDetailList()
 * @method Collection prepareViewComponentDetailList(? array $attributes = null)
 * @method LengthAwarePaginator prepareViewComponentDetailPaginate(PaginateData $paginate_dto)
 * @method array viewComponentDetailPaginate(?PaginateData $paginate_dto = null)
 * @method Builder function tariffComponent(mixed $conditionals = null)
 */
interface ComponentDetail extends DataManagement
{
}
