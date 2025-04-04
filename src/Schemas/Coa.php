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

    protected function viewUsingRelation(): array{
        return [];
    }

    protected function showUsingRelation(): array{
        return [];
    }

    public function getCoa(): mixed{
        return static::$coa_model;
    }

    public function prepareStoreCoa(CoaData $coa_dto): Model{
        $model = $this->CoaModel()->updateOrCreate([
            'name'   => $coa_dto->name,
            'code'   => $coa_dto->code
        ],[
            'status' => $coa_dto->status
        ]);

        return static::$coa_model = $model;
    }

    public function storeCoa(?CoaData $coa_dto = null): array{
        return $this->transaction(function() use ($coa_dto){
            return $this->showCoa($this->prepareStoreCoa($coa_dto ?? $this->requestDTO(CoaData::class)));
        });
    }

    public function prepareShowCoa(?Model $model = null, ?array $attributes = null): Model{
        $attributes ??= request()->all();

        $model ??= $this->getCoa();
        if (isset($attributes['id'])) {
            $id = $attributes['id'] ?? null;
            if (!isset($id)) throw new \Exception('Id not found');
            $model = $this->coa()->with($this->showUsingRelation())->findOrFail($id);
        } else {
            $model->load($this->showUsingRelation());
        }
        return static::$coa_model = $model;
    }

    public function showCoa(?Model $model = null): array{
        return $this->showEntityResource(function() use ($model){
            return $this->prepareShowCoa($model);
        });
    }

    public function prepareViewCoaList(?array $attributes = null): Collection{
        $attributes ??= request()->all();

        return static::$coa_model = $this->coa()->with($this->viewUsingRelation())->orderBy('name', 'asc')->get();
    }

    public function viewCoaList(): array{
        return $this->viewEntityResource(function(){
            return $this->prepareViewCoalist();
        });
    }

    public function prepareDeleteCoa(?array $attributes = null): bool{
        $attributes ??= request()->all();
        if (!isset($attributes['id'])) throw new \Exception('Id not found');

        $model = $this->coa()->findOrFail($attributes['id']);
        return $model->delete();
    }

    public function deleteCoa(): bool{
        return $this->transaction(function () {
            return $this->prepareDeleteCoa();
        });
    }

    public function coa(mixed $conditionals = null): Builder{
        $this->booting();
        return $this->CoaModel()->withParameters()->conditionals($this->mergeCondition($conditionals ?? []))->orderBy('name','asc');
    }
}
