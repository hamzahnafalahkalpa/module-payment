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

    protected function after(mixed $data): AccountGroupData{
        $data->flag = 'AccountGroup';
        return $data;
    }
}