<?php

namespace Hanafalah\ModulePayment\Schemas;

use Illuminate\Database\Eloquent\Model;
use Hanafalah\LaravelSupport\Supports\PackageManagement;
use Hanafalah\ModulePayment\Contracts\Schemas\Coa as ContractsCoa;
use Hanafalah\ModulePayment\Contracts\Data\CoaData;

class Coa extends PackageManagement implements ContractsCoa
{
    protected string $__entity = 'Coa';
    public static $coa_model;

    public function prepareStoreCoa(CoaData $coa_dto): Model{
        $add = [
            'parent_id'     => $coa_dto->parent_id,
            'name'          => $coa_dto->name,
            'flag'          => $coa_dto->flag,
            'code'          => $coa_dto->code ?? null,
            'coa_type_id'   => $coa_dto->coa_type_id ?? null,
            'status'        => $coa_dto->status,
            'balance_type'  => $coa_dto->balance_type
        ];
        if (isset($coa_dto->id)){
            $group  = ['id' => $coa_dto->id];
            $create = [$group,$add];
        }else{
            $create = [$add];
        }

        if ($coa_dto->flag == 'Coa'){
            $model = $this->CoaModel()->updateOrCreate(...$create);
            if (!isset($coa_dto->props['prop_parent']['name']) && isset($coa_dto->parent_id)){
                $parent = $this->usingEntity()->findOrFail($coa_dto->parent_id);
                $coa_dto->props['prop_parent']['id'] = $parent->getKey();
                $coa_dto->props['prop_parent']['name'] = $parent->name;
            }
        }else{
            $model = $this->usingEntity()->updateOrCreate(...$create);
        }

        if (!isset($coa_dto->props['prop_coa_type']['name']) && isset($coa_dto->coa_type_id)){
            $coa_type = $this->CoaModel()->findOrFail($coa_dto->coa_type_id);
            $coa_dto->props['prop_coa_type']['id']   = $coa_type->getKey();
            $coa_dto->props['prop_coa_type']['name'] = $coa_type->name;
        }

        $this->fillingProps($model,$coa_dto->props);
        $model->save();
        return static::$coa_model = $model;
    }
}