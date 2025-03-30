<?php

namespace Hanafalah\ModulePayment\Models\Price;

use Hanafalah\LaravelSupport\Models\BaseModel;
use Hanafalah\ModulePayment\Enums\TariffComponent\Flag;
use Hanafalah\ModulePayment\Resources\TariffComponent\ShowTariffComponent;
use Hanafalah\ModulePayment\Resources\TariffComponent\ViewTariffComponent;

class TariffComponent extends BaseModel
{
    protected $fillable = ['id', 'name'];

    protected $casts = [
        'name' => 'string'
    ];

    public function getViewResource()
    {
        return ViewTariffComponent::class;
    }

    public function getShowResource()
    {
        return ShowTariffComponent::class;
    }

    public function getFlags()
    {
        return array_column(Flag::cases(), 'value');
    }

    public function componentDetails()
    {
        return $this->morphManyModel('ComponentDetail', 'reference');
    }
}
