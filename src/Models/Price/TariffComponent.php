<?php

namespace Hanafalah\ModulePayment\Models\Price;

use Hanafalah\LaravelSupport\Models\BaseModel;
use Hanafalah\ModulePayment\Enums\TariffComponent\Flag;
use Hanafalah\ModulePayment\Resources\TariffComponent\ShowTariffComponent;
use Hanafalah\ModulePayment\Resources\TariffComponent\ViewTariffComponent;
use Illuminate\Database\Eloquent\Concerns\HasUlids;

class TariffComponent extends BaseModel
{
    use HasUlids;

    public $incrementing  = false;
    protected $keyType    = 'string';
    protected $primaryKey = 'id';
    protected $fillable   = ['id', 'name'];
    protected $casts = [
        'name' => 'string'
    ];

    public function getViewResource(){
        return ViewTariffComponent::class;
    }

    public function getShowResource(){
        return ShowTariffComponent::class;
    }

    public function getFlags(){
        return array_column(Flag::cases(), 'value');
    }

    public function componentDetails(){
        return $this->morphManyModel('ComponentDetail', 'reference');
    }
}
