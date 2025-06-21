<?php

namespace Hanafalah\ModulePayment\Models\Price;

use Hanafalah\LaravelSupport\Models\Unicode\Unicode;
use Hanafalah\ModulePayment\Resources\FinanceStuff\{
    ViewFinanceStuff,
    ShowFinanceStuff
};

class FinanceStuff extends Unicode
{
    protected $table = 'unicodes';

    protected static function booted(): void{
        parent::booted();
        static::addGlobalScope('flag',function($query){
            $query->flagIn('FinanceStuff');
        });
        static::creating(function($query){
            $query->flag = 'FinanceStuff';
        });
    }

    public function getViewResource(){return ViewFinanceStuff::class;}
    public function getShowResource(){return ShowFinanceStuff::class;}
}
