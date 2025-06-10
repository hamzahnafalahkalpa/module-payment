<?php

namespace Hanafalah\ModulePayment\Models\Price;

class CoaType extends FinanceStuff
{
    protected $table = 'finance_stuffs';

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
