<?php

namespace Hanafalah\ModulePayment\Schemas;

use Hanafalah\LaravelSupport\Schemas\Unicode;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Hanafalah\ModulePayment\Contracts\Schemas\FinanceStuff as ContractsFinanceStuff;
use Hanafalah\ModulePayment\Contracts\Data\FinanceStuffData;

class FinanceStuff extends Unicode implements ContractsFinanceStuff
{
    protected string $__entity = 'FinanceStuff';
    public $finance_stuff_model;
    protected mixed $__order_by_created_at = false; //asc, desc, false

    protected array $__cache = [
        'index' => [
            'name'     => 'finance_stuff',
            'tags'     => ['finance_stuff', 'finance_stuff-index'],
            'duration' => 24 * 60
        ]
    ];

    public function prepareStoreFinanceStuff(FinanceStuffData $finance_stuff_dto): Model{
        $finance_stuff = $this->prepareStoreUnicode($finance_stuff_dto);
        return $this->finance_stuff_model = $finance_stuff;
    }

    public function financeStuff(mixed $conditionals = null): Builder{
        return $this->unicode($conditionals);
    }
}