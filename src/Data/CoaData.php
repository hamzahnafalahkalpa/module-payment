<?php

namespace Hanafalah\ModulePayment\Data;

use Hanafalah\LaravelSupport\Supports\Data;
use Hanafalah\ModulePayment\Contracts\Data\CoaData as DataCoaData;
use Hanafalah\ModulePayment\Enums\Bank\Status;
use Spatie\LaravelData\Attributes\DataCollectionOf;
use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Attributes\MapName;

class CoaData extends Data implements DataCoaData
{
    #[MapInputName('id')]
    #[MapName('id')]
    public mixed $id = null;

    #[MapInputName('parent_id')]
    #[MapName('parent_id')]
    public mixed $parent_id = null;

    #[MapInputName('name')]
    #[MapName('name')]
    public string $name;

    #[MapInputName('flag')]
    #[MapName('flag')]
    public ?string $flag = null;

    #[MapInputName('code')]
    #[MapName('code')]
    public ?string $code = null;

    #[MapInputName('status')]
    #[MapName('status')]
    public ?string $status = Status::ACTIVE->value;

    #[MapInputName('childs')]
    #[MapName('childs')]
    #[DataCollectionOf(CoaData::class)]
    public ?array $childs = [];

    protected function after(CoaData $data): CoaData{
        $data->flag = 'Coa';
        return $data;
    }
}
