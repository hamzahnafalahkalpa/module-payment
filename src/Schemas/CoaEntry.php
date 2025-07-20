<?php

namespace Hanafalah\ModulePayment\Schemas;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Hanafalah\ModulePayment\{
    Supports\BaseModulePayment
};
use Hanafalah\ModulePayment\Contracts\Schemas\CoaEntry as ContractsCoaEntry;
use Hanafalah\ModulePayment\Contracts\Data\CoaEntryData;

class CoaEntry extends BaseModulePayment implements ContractsCoaEntry
{
    protected string $__entity = 'CoaEntry';
    public $coa_entry_model;

    protected array $__cache = [
        'index' => [
            'name'     => 'coa_entry',
            'tags'     => ['coa_entry', 'coa_entry-index'],
            'duration' => 24 * 60
        ]
    ];

    public function prepareStoreCoaEntry(CoaEntryData $coa_entry_dto): Model{
        $add = [
            'balance_type' => $coa_entry_dto->balance_type,
            'value' => $coa_entry_dto->value
        ];
        if (isset($coa_entry_dto->id)){
            $guard  = ['id' => $coa_entry_dto->id];
        }else{
            $guard  = [
                'journal_entry_id' => $coa_entry_dto->journal_entry_id,
                'coa_id' => $coa_entry_dto->coa_id
            ];
        }
        $create = [$guard, $add];

        $coa_entry = $this->usingEntity()->updateOrCreate(...$create);
        $this->fillingProps($coa_entry,$coa_entry_dto->props);
        $coa_entry->save();
        return $this->coa_entry_model = $coa_entry;
    }
}