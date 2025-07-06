<?php

namespace Hanafalah\ModulePayment\Data;

use Hanafalah\LaravelSupport\Supports\Data;
use Hanafalah\ModulePayment\Contracts\Data\ComponentDetailData as DataComponentDetailData;
use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Attributes\MapName;

class ComponentDetailData extends Data implements DataComponentDetailData
{
    #[MapInputName('id')]
    #[MapName('id')]
    public mixed $id = null;

    #[MapInputName('reference_type')]
    #[MapName('reference_type')]
    public ?string $reference_type = null;

    #[MapInputName('reference_id')]
    #[MapName('reference_id')]
    public mixed $reference_id = null;

    #[MapInputName('flag')]
    #[MapName('flag')]
    public mixed $flag = null;

    #[MapInputName('coa_id')]
    #[MapName('coa_id')]
    public mixed $coa_id = null;

    #[MapInputName('props')]
    #[MapName('props')]
    public ?array $props = null;

    public static function after(self $data): self{
        $new = static::new();

        $props = &$data->props;
        $coa   = $new->CoaModel();
        if (isset($data->coa_id)) $coa = $coa->findOrFail($data->coa_id);
        $props['prop_coa'] = $coa->toViewApi()->resolve();
        return $data;
    }
}