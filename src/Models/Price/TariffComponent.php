<?php

namespace Hanafalah\ModulePayment\Models\Price;

use Hanafalah\ModulePayment\Resources\TariffComponent\ShowTariffComponent;
use Hanafalah\ModulePayment\Resources\TariffComponent\ViewTariffComponent;

class TariffComponent extends FinanceStuff
{
    protected $table = 'unicodes';

    public function showUsingRelation(): array{
        return ['componentDetails'];
    }

    public function getViewResource(){
        return ViewTariffComponent::class;
    }

    public function getShowResource(){
        return ShowTariffComponent::class;
    }

    public function componentDetails(){return $this->morphManyModel('ComponentDetail', 'reference');}
}
