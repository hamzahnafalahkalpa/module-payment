<?php

namespace Hanafalah\ModulePayment\Schemas;

use Illuminate\Database\Eloquent\Model;
use Hanafalah\LaravelSupport\Supports\PackageManagement;
use Hanafalah\ModulePayment\Contracts\Schemas\TariffComponent as ContractsTariffComponent;

class TariffComponent extends PackageManagement implements ContractsTariffComponent
{
    protected string $__entity = 'TariffComponent';
    public static $tariff_model;

    protected array $__cache = [
        'index' => [
            'name'     => 'tariff-component',
            'tags'     => ['tariff-component', 'tariff-component-index'],
            'duration' => 26 * 60
        ]
    ];

    public function prepareStoreTariffComponent(?array $attributes = null): Model{
        $attributes ??= request()->all();
        $tariff = $this->TariffComponentModel()->updateOrCreate([
            'id' => $attributes['id'] ?? null
        ], [
            'name' => $attributes['name']
        ]);

        $tariff->componentDetails()->delete();
        if (isset($attributes['component_details']) && count($attributes['component_details']) > 0) {
            foreach ($attributes['component_details'] as $component) {
                $component_model = $tariff->componentDetails()->create(['flag' => $component['flag']]);
                if (isset($component['coa_account_id'])) $component_model->jurnal = ["coa_account_id" => $component['coa_account_id']];
                $component_model->save();
            }

            $this->addSuffixCache($this->__cache['index'], "tariff-component-index", '');
            $this->flushTagsFrom('index');
        }

        $this->forgetTags('tariff-component');
        return static::$tariff_model = $tariff;
    }
}
