<?php

namespace Hanafalah\ModulePayment\Schemas;

use Illuminate\Database\Eloquent\Model;
use Hanafalah\LaravelSupport\Supports\PackageManagement;
use Hanafalah\ModulePayment\Contracts\Schemas\Consument as ContractsConsument;
use Hanafalah\ModulePayment\Contracts\Data\ConsumentData;
use Illuminate\Support\Str;

class Consument extends PackageManagement implements ContractsConsument
{
    protected string $__entity = 'Consument';
    public $consument_model;

    public function prepareStoreConsument(ConsumentData $consument_dto): Model{
        $add = [
            'name'           => $consument_dto->name,
            'reference_type' => $consument_dto->reference_type ?? null,
            'reference_id'   => $consument_dto->reference_id ?? null,
            'phone'          => $consument_dto->phone ?? null,
        ];
        if (isset($consument_dto->id)){
            $group  = ['id' => $consument_dto->id];
            $create = [$group,$add];
        }else{
            $create = [$add];
        }
        $consument = $this->usingEntity()->updateOrCreate(...$create);

        if (isset($consument_dto->reference_type) && isset($consument_dto->reference_id)) {
            $reference = $this->{$consument_dto->reference_type.'Model'}()->findOrFail($consument_dto->reference_id);
            $consument_dto->props['prop_'.Str::snake($consument_dto->reference_type)] = $reference->toViewApi()->resolve();
        }

        $this->fillingProps($consument,$consument_dto->props);
        $consument->save();
        return $this->consument_model = $consument;
    }
}