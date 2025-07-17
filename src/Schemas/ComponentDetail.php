<?php

namespace Hanafalah\ModulePayment\Schemas;

use Hanafalah\LaravelSupport\Supports\PackageManagement;
use Illuminate\Database\Eloquent\Model;
use Hanafalah\ModulePayment\Contracts\Data\ComponentDetailData;
use Hanafalah\ModulePayment\Contracts\Schemas\ComponentDetail as ContractsComponentDetail;

class ComponentDetail extends PackageManagement implements ContractsComponentDetail
{
    protected string $__entity = 'ComponentDetail';
    public static $component_detail_model;

    protected array $__cache = [
        'index' => [
            'name'     => 'component_detail',
            'tags'     => ['component_detail', 'component_detail-index'],
            'duration' => 26 * 60
        ]
    ];

    public function prepareStoreComponentDetail(ComponentDetailData $component_detail_dto): Model{
        $add = [
            'reference_type'   => $component_detail_dto->reference_type,
            'reference_id'     => $component_detail_dto->reference_id,
            'flag'             => $component_detail_dto->flag,
            'coa_id'           => $component_detail_dto->coa_id
        ];
        if (isset($component_detail_dto->id)){
            $guard = ['id' => $component_detail_dto->id];
            $create = [$guard,$add];
        }else{
            $create = [$add];
        }
        $component_detail = $this->usingEntity()->updateOrCreate(...$create);
        $this->fillingProps($component_detail,$component_detail_dto->props);
        $component_detail->save();
        return static::$component_detail_model = $component_detail;
    }
}
