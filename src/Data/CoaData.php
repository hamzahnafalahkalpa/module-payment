<?php

namespace Hanafalah\ModulePayment\Data;

use Hanafalah\LaravelSupport\Supports\Data;
use Hanafalah\ModulePayment\Contracts\Data\CoaData as DataCoaData;
use Hanafalah\ModulePayment\Contracts\Data\CoaTypeData;
use Hanafalah\ModulePayment\Enums\Bank\Status;
use Hanafalah\ModulePayment\Enums\Coa\BalanceType;
use Spatie\LaravelData\Attributes\DataCollectionOf;
use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Attributes\MapName;
use Spatie\LaravelData\Attributes\Validation\Enum;

class CoaData extends Data implements DataCoaData
{
    #[MapInputName('id')]
    #[MapName('id')]
    public mixed $id = null;

    #[MapInputName('parent_id')]
    #[MapName('parent_id')]
    public mixed $parent_id = null;

    #[MapInputName('account_group_id')]
    #[MapName('account_group_id')]
    public mixed $account_group_id = null;

    #[MapInputName('name')]
    #[MapName('name')]
    public string $name;

    #[MapInputName('balance_type')]
    #[MapName('balance_type')]
    #[Enum(BalanceType::class)]
    public ?string $balance_type = null;

    #[MapInputName('flag')]
    #[MapName('flag')]
    public ?string $flag = null;

    #[MapInputName('code')]
    #[MapName('code')]
    public ?string $code = null;

    #[MapInputName('parent_code')]
    #[MapName('parent_code')]
    public ?string $parent_code = null;

    #[MapInputName('coa_type_id')]
    #[MapName('coa_type_id')]
    public ?string $coa_type_id = null;

    #[MapInputName('coa_type')]
    #[MapName('coa_type')]
    public ?CoaTypeData $coa_type = null;

    #[MapInputName('status')]
    #[MapName('status')]
    public ?string $status = Status::ACTIVE->value;

    #[MapInputName('childs')]
    #[MapName('childs')]
    #[DataCollectionOf(CoaData::class)]
    public ?array $childs = [];

    #[MapInputName('props')]
    #[MapName('props')]
    public ?array $props = null;

    public static function after(CoaData $data): CoaData{
        $data->flag ??= 'Coa';

        if (isset($data->account_group_id)){
            $data->parent_id = $data->account_group_id;
        }

        $data->props['prop_coa_type'] = [
            'id'   => $data->coa_type_id ?? null,
            'name' => null
        ];
        $new = static::new();
        if (!isset($data->props['prop_coa_type']['name']) && isset($data->coa_type_id)){
            $coa_type = $new->CoaTypeModel()->findOrFail($data->coa_type_id);
            $data->props['prop_coa_type']['name'] = $coa_type->name;
        }

        if (isset($data->parent_code)){
            $parent = $new->CoaModel()->where('code', $data->parent_code)->firstOrFail();
            $data->parent_id = $parent->id;
        }

        $data->props['prop_parent'] = [
            'id'   => $data->parent_id ?? null,
            'name' => null
        ];

        if (!isset($data->props['prop_parent']['name']) && isset($data->parent_id)){
            $parent = $new->CoaModel()->findOrFail($data->parent_id);
            $data->props['prop_parent']['name'] = $parent->name;
        }        

        return $data;
    }
}
