<?php

namespace Hanafalah\ModulePayment\Schemas;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Hanafalah\LaravelSupport\Schemas\Unicode;
use Hanafalah\ModulePayment\Contracts\Schemas\CoaTemplate as ContractsCoaTemplate;
use Hanafalah\ModulePayment\Contracts\Data\CoaTemplateData;

class CoaTemplate extends Unicode implements ContractsCoaTemplate
{
    protected string $__entity = 'CoaTemplate';
    public $coa_template_model;
    //protected mixed $__order_by_created_at = false; //asc, desc, false

    protected array $__cache = [
        'index' => [
            'name'     => 'coa_template',
            'tags'     => ['coa_template', 'coa_template-index'],
            'duration' => 24 * 60
        ]
    ];

    public function prepareStoreCoaTemplate(CoaTemplateData $coa_template_dto): Model{
        $coa_template = $this->prepareStoreUnicode($coa_template_dto);
        $this->fillingProps($coa_template,$coa_template_dto->props);
        $coa_template->save();
        return $this->coa_template_model = $coa_template;
    }

    public function coaTemplate(mixed $conditionals = null): Builder{
        return $this->unicode($conditionals);
    }
}