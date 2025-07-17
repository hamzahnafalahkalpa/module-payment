<?php

namespace Hanafalah\ModulePayment\Schemas;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Hanafalah\ModulePayment\Contracts\Schemas\CoaType as ContractsCoaType;
use Hanafalah\ModulePayment\Contracts\Data\CoaTypeData;

class CoaType extends FinanceStuff implements ContractsCoaType
{
    protected string $__entity = 'CoaType';
    public static $coa_type_model;

    protected array $__cache = [
        'index' => [
            'name'     => 'coa_type',
            'tags'     => ['coa_type', 'coa_type-index'],
            'duration' => 24 * 60
        ]
    ];

    public function prepareStoreCoaType(CoaTypeData $coa_type_dto): Model{
        $coa_type = $this->usingEntity()->updateOrCreate([
                        'id' => $coa_type_dto->id ?? null
                    ], [
                        'name' => $coa_type_dto->name
                    ]);
        $this->fillingProps($coa_type,$coa_type_dto->props);
        $coa_type->save();
        return static::$coa_type_model = $coa_type;
    }

    public function coaType(mixed $conditionals = null): Builder{
        return $this->generalSchemaModel()->whereNull('parent_id');
    }
}