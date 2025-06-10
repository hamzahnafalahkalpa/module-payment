<?php

namespace Hanafalah\ModulePayment\Schemas;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Hanafalah\ModulePayment\{
    Supports\BaseModulePayment
};
use Hanafalah\ModulePayment\Contracts\Schemas\FinanceStuff as ContractsFinanceStuff;
use Hanafalah\ModulePayment\Contracts\Data\FinanceStuffData;

class FinanceStuff extends BaseModulePayment implements ContractsFinanceStuff
{
    protected string $__entity = 'FinanceStuff';
    public static $finance_stuff_model;

    protected array $__cache = [
        'index' => [
            'name'     => 'finance_stuff',
            'tags'     => ['finance_stuff', 'finance_stuff-index'],
            'duration' => 24 * 60
        ]
    ];

    public function prepareStoreFinanceStuff(FinanceStuffData $finance_stuff_dto): Model{
        $add = [
            'parent_id' => $finance_stuff_dto->parent_id,
            'name'      => $finance_stuff_dto->name,
            'flag'      => $finance_stuff_dto->flag
        ];
        if (isset($finance_stuff_dto->id)){
            $guard = ['id' => $finance_stuff_dto->id];
            $create = [$guard,$add];
        }else{
            $create = [$add];
        }
        $finance_stuff = $this->usingEntity()->updateOrCreate(...$create);
        $this->fillingProps($finance_stuff,$finance_stuff_dto->props);
        $finance_stuff->save();
        return static::$finance_stuff_model = $finance_stuff;
    }

    public function financeStuff(mixed $conditionals = null): Builder{
        return $this->usingEntity()->whereNull('parent_id')
                    ->conditionals($this->mergeCondition($conditionals))
                    ->withParameters()->orderBy('name','asc');
    }
}