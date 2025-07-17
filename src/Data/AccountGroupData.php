<?php

namespace Hanafalah\ModulePayment\Data;

use Hanafalah\ModulePayment\Contracts\Data\AccountGroupData as DataAccountGroupData;
use Spatie\LaravelData\Attributes\DataCollectionOf;
use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Attributes\MapName;

class AccountGroupData extends CoaData implements DataAccountGroupData
{
    #[MapInputName('coas')]
    #[MapName('coas')]
    #[DataCollectionOf(CoaData::class)]
    public ?array $coas = [];

    public static function after(mixed $data): AccountGroupData{
        $data = parent::after($data);
        return $data;
    }
}