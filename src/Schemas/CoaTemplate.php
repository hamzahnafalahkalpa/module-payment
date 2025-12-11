<?php

namespace Hanafalah\ModulePayment\Schemas;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Hanafalah\ModulePayment\{
    Supports\BaseModulePayment
};
use Hanafalah\ModulePayment\Contracts\Schemas\CoaTemplate as ContractsCoaTemplate;
use Hanafalah\ModulePayment\Contracts\Data\CoaTemplateData;

class CoaTemplate extends BaseModulePayment implements ContractsCoaTemplate
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
        $add = [
            'name' => $coa_template_dto->name
        ];
        $guard  = ['id' => $coa_template_dto->id];
        $create = [$guard, $add];
        // if (isset($coa_template_dto->id)){
        //     $guard  = ['id' => $coa_template_dto->id];
        //     $create = [$guard, $add];
        // }else{
        //     $create = [$add];
        // }

        $coa_template = $this->usingEntity()->updateOrCreate(...$create);
        $this->fillingProps($coa_template,$coa_template_dto->props);
        $coa_template->save();
        return $this->coa_template_model = $coa_template;
    }
}