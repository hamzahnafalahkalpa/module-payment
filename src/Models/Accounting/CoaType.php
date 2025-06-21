<?php

namespace Hanafalah\ModulePayment\Models\Accounting;

use Hanafalah\ModulePayment\Models\Price\FinanceStuff;

class CoaType extends FinanceStuff
{
    protected $table = 'unicodes';

    protected static function booted(): void{
        parent::booted();
        static::addGlobalScope('coa_flag',function ($query) {
            $query->isCoaType();
        });
        static::creating(function ($query) {
            $query->flag ??= 'CoaType';
        });
    }

    public function scopeIsCoaType($builder){return $builder->where('flag','CoaType');}
}
