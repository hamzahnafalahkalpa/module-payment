<?php

namespace Hanafalah\ModulePayment\Contracts\Schemas;

use Hanafalah\ModulePayment\Contracts\Data\CoaTemplateData;
//use Hanafalah\ModulePayment\Contracts\Data\CoaTemplateUpdateData;
use Hanafalah\LaravelSupport\Contracts\Supports\DataManagement;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Hanafalah\LaravelSupport\Contracts\Schemas\Unicode;

/**
 * @see \Hanafalah\ModulePayment\Schemas\CoaTemplate
 * @method mixed export(string $type)
 * @method self conditionals(mixed $conditionals)
 * @method array updateCoaTemplate(?CoaTemplateData $coa_template_dto = null)
 * @method Model prepareUpdateCoaTemplate(CoaTemplateData $coa_template_dto)
 * @method bool deleteCoaTemplate()
 * @method bool prepareDeleteCoaTemplate(? array $attributes = null)
 * @method mixed getCoaTemplate()
 * @method ?Model prepareShowCoaTemplate(?Model $model = null, ?array $attributes = null)
 * @method array showCoaTemplate(?Model $model = null)
 * @method Collection prepareViewCoaTemplateList()
 * @method array viewCoaTemplateList()
 * @method LengthAwarePaginator prepareViewCoaTemplatePaginate(PaginateData $paginate_dto)
 * @method array viewCoaTemplatePaginate(?PaginateData $paginate_dto = null)
 * @method array storeCoaTemplate(?CoaTemplateData $coa_template_dto = null)
 * @method Collection prepareStoreMultipleCoaTemplate(array $datas)
 * @method array storeMultipleCoaTemplate(array $datas)
 */

interface CoaTemplate extends Unicode
{
    public function prepareStoreCoaTemplate(CoaTemplateData $coa_template_dto): Model;
    public function coaTemplate(mixed $conditionals = null): Builder;
}