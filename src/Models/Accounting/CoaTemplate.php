<?php

namespace Hanafalah\ModulePayment\Models\Accounting;

use Hanafalah\ModulePayment\Resources\CoaTemplate\{
    ViewCoaTemplate,
    ShowCoaTemplate
};
use Hanafalah\LaravelSupport\Models\Unicode\Unicode;

class CoaTemplate extends Unicode
{
    protected $table = 'unicodes';

    public function viewUsingRelation(): array{
        return [];
    }

    public function showUsingRelation(): array{
        return [];
    }

    public function getViewResource(){
        return ViewCoaTemplate::class;
    }

    public function getShowResource(){
        return ShowCoaTemplate::class;
    }

    

    
}
