<?php

namespace Hanafalah\ModulePayment\Schemas;

use Hanafalah\LaravelSupport\Schemas\Unicode;
use Illuminate\Database\Eloquent\Model;
use Hanafalah\ModulePayment\Contracts\Data\TariffComponentData;
use Hanafalah\ModulePayment\Contracts\Schemas\TariffComponent as ContractsTariffComponent;

class TariffComponent extends Unicode implements ContractsTariffComponent
{
    protected string $__entity = 'TariffComponent';
    public $tariff_component_model;

    protected array $__cache = [
        'index' => [
            'name'     => 'tariff_component',
            'tags'     => ['tariff_component', 'tariff_component-index'],
            'duration' => 26 * 60
        ]
    ];

    public function prepareStoreTariffComponent(TariffComponentData $tariff_component_dto): Model{
        $tariff = $this->usingEntity()->updateOrCreate([
            'id' => $tariff_component_dto->id ?? null
        ], [
            'name' => $tariff_component_dto->name
        ]);

        $tariff->componentDetails()->delete();
        if (isset($tariff_component_dto->component_details) && count($tariff_component_dto->component_details) > 0) {
            foreach ($tariff_component_dto->component_details as $component_dto) {
                $component_dto->reference_id = $tariff->getKey();
                $component_dto->reference_type = $tariff->getMorphClass();
                $this->schemaContract('component_detail')->prepareStoreComponentDetail($component_dto);
            }
        }
        $this->fillingProps($tariff,$tariff_component_dto->props);
        $tariff->save();
        return $this->tariff_component_model = $tariff;
    }
}
