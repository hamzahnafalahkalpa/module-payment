<?php

namespace Hanafalah\ModulePayment\Models\Accounting;

use Hanafalah\ModulePayment\Models\Price\FinanceStuff;
use Hanafalah\ModulePayment\Resources\JournalSource\{
    ViewJournalSource,
    ShowJournalSource
};

class JournalSource extends FinanceStuff
{
    protected $table    = 'finance_stuffs';


    protected static function booted(): void{
        parent::booted();
        static::addGlobalScope('flag',function($query){
            $query->flagIn('JournalSource');
        });
        static::creating(function($query){
            $query->flag = 'JournalSource';
        });
    }

    public function viewUsingRelation(): array{
        return [];
    }

    public function showUsingRelation(): array{
        return [];
    }

    public function getViewResource(){
        return ViewJournalSource::class;
    }

    public function getShowResource(){
        return ShowJournalSource::class;
    }
}
