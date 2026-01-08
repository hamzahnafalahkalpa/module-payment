<?php

namespace Hanafalah\ModulePayment\Schemas;

use Illuminate\Database\Eloquent\Model;
use Hanafalah\LaravelSupport\Supports\PackageManagement;
use Hanafalah\ModulePayment\Contracts\Schemas\Coa as ContractsCoa;
use Hanafalah\ModulePayment\Contracts\Data\CoaData;
use Illuminate\Database\Eloquent\Builder;

class Coa extends PackageManagement implements ContractsCoa
{
    protected string $__entity = 'Coa';
    public $coa_model;

    public function prepareStoreCoa(CoaData $coa_dto): Model{
        if (isset($coda_dto->coa_type)){
            $coa_type_model = $this->schemaContract('coa_type')->prepareStoreCoaType($coa_dto->coa_type);
            $coa_dto->coa_type_model = $coa_type_model;
            $coa_dto->coa_type_id = $coa_type_model->getKey();
            $coa_dto->props['prop_coa_type'] = [
                'id'   => $coa_type_model->getKey(),
                'name' => $coa_type_model->name
            ];
        }

        $add = [
            'name'          => $coa_dto->name,
            'flag'          => $coa_dto->flag,
            'code'          => $coa_dto->code ?? null,
            'coa_type_id'   => $coa_dto->coa_type_id ?? null,
            'status'        => $coa_dto->status ?? 'ACTIVE',
            'balance_type'  => $coa_dto->balance_type,
        ];
        if (isset($coa_dto->id)){
            $group  = ['id' => $coa_dto->id];
            $add['parent_id'] = $coa_dto->parent_id ?? null;
        }else{
            $group = [
                'parent_id'     => $coa_dto->parent_id,
                'reference_type' => $coa_dto->reference_type,
                'reference_id'   => $coa_dto->reference_id,
                'coa_template_id' => $coa_dto->coa_template_id ?? null
            ];
            if (!config('app.is_seeding',false)){
                $group['id'] = null;
            }
        }
        $create = [$group,$add];

        if (isset($coa_dto->parent_id)){
            $model = $this->usingEntity()->updateOrCreate(...$create);
            if (!isset($coa_dto->props['prop_parent']['name']) && isset($coa_dto->parent_id)){
                $parent = $coa_dto->parent_model ?? $this->usingEntity()->findOrFail($coa_dto->parent_id);
                $coa_dto->props['prop_parent']['id'] = $parent->getKey();
                $coa_dto->props['prop_parent']['name'] = $parent->name;
            }
        }else{
            $model = $this->usingEntity()->updateOrCreate(...$create);
        }

        if (!isset($coa_dto->props['prop_coa_type']['name']) && isset($coa_dto->coa_type_id)){
            $coa_type = $coa_dto->coa_type_model ?? $this->CoaTypeModel()->findOrFail($coa_dto->coa_type_id);
            $coa_dto->props['prop_coa_type']['id']   = $coa_type->getKey();
            $coa_dto->props['prop_coa_type']['name'] = $coa_type->name;
        }

        if (isset($coa_dto->childs) && count($coa_dto->childs) > 0){
            foreach ($coa_dto->childs as &$child_coa_dto){
                $child_coa_dto->parent_id     = $model->getKey();
                $child_coa_dto->parent_model  = $model;
                $child_coa_dto->coa_type_id ??= $coa_dto->coa_type_id ?? null;
                $this->prepareStoreCoa($child_coa_dto);
            }
        }

        $this->fillingProps($model,$coa_dto->props);
        $model->save();
        return $this->coa_model = $model;
    }

    public function coa(mixed $conditionals = null): Builder{
        return parent::generalSchemaModel($conditionals)->whereNull('parent_id');
    }
}