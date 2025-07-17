<?php

namespace Hanafalah\ModulePayment\Models\Accounting;

use Hanafalah\ModulePayment\Resources\AccountGroup\ShowAccountGroup;
use Hanafalah\ModulePayment\Resources\AccountGroup\ViewAccountGroup;
use Hanafalah\ModulePayment\Enums\Coa\Status;

class AccountGroup extends Coa
{
    protected $table = 'coas';

    protected static function booted(): void{
        parent::booted();
        static::addGlobalScope('coa-status', function ($query) {
            $query->whereNull('parent_id')
                  ->where('status', Status::ACTIVE->value);
        });
    }

    public function getViewResource(){
        return ViewAccountGroup::class;
    }

    public function getShowResource(){
        return ShowAccountGroup::class;
    }

    public function viewUsingRelation(): array
    {
        return ['coas'];
    }

    public function showUsingRelation(): array
    {
        return array_merge($this->viewUsingRelation(), [

        ]);
    }

    public function coas(){return $this->hasManyModel('Coa', 'parent_id');}
}
