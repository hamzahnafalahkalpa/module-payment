<?php

namespace Hanafalah\ModulePayment\Data;

use Hanafalah\LaravelSupport\Supports\Data;
use Hanafalah\ModulePayment\Contracts\Data\CoaData as DataCoaData;
use Hanafalah\ModulePayment\Enums\Bank\Status;
use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Attributes\MapName;

class CoaData extends Data implements DataCoaData
{
    public function __construct(
        #[MapInputName('id')]
        #[MapName('id')]
        public mixed $id = null,

        #[MapInputName('name')]
        #[MapName('name')]
        public string $name,

        #[MapInputName('code')]
        #[MapName('code')]
        public string $code,

        #[MapInputName('status')]
        #[MapName('status')]
        public ?string $status = Status::ACTIVE->value
    ) {}
}
