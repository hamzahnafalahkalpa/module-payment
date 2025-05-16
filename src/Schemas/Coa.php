<?php

namespace Hanafalah\ModulePayment\Schemas;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
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
            'parent_id' => $coa_dto->parent_id,
            'name'      => $coa_dto->name,
            'flag'      => $coa_dto->flag,
            'code'      => $coa_dto->code ?? null,
            'status'    => $coa_dto->status
        ];
        if (isset($coa_dto->id)){
            $group  = ['id' => $coa_dto->id];
            $create = [$group,$add];
        }else{
            $create = [$add];
        }

        if ($coa_dto->flag == 'Coa'){
            $model = $this->CoaModel()->updateOrCreate(...$create);
        }else{
            $model = $this->usingEntity()->updateOrCreate(...$create);
        }
        return static::$coa_model = $model;
    }
}