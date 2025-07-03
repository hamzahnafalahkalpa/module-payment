<?php

namespace Hanafalah\ModulePayment\Data;

use Hanafalah\LaravelSupport\Data\UnicodeData;
use Hanafalah\ModulePayment\Contracts\Data\TariffComponentData as DataTariffComponentData;
use Hanafalah\ModulePayment\Models\Price\ComponentDetail;
use Spatie\LaravelData\Attributes\DataCollectionOf;
use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Attributes\MapName;

class TariffComponentData extends UnicodeData implements DataTariffComponentData
{
    #[MapName('component_details')]
    #[MapInputName('component_details')]
    #[DataCollectionOf(ComponentDetail::class)]
    public ?array $component_details = [];

    public static function before(array &$attributes){
        $attributes['flag'] ??= 'TariffComponent';
    }
}
