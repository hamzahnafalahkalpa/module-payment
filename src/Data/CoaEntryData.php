<?php

namespace Hanafalah\ModulePayment\Data;

use Hanafalah\LaravelSupport\Supports\Data;
use Hanafalah\ModulePayment\Contracts\Data\CoaEntryData as DataCoaEntryData;
use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Attributes\MapName;
use Spatie\LaravelData\Attributes\Validation\In;

class CoaEntryData extends Data implements DataCoaEntryData
{
    #[MapInputName('id')]
    #[MapName('id')]
    public mixed $id = null;

    #[MapInputName('coa_id')]
    #[MapName('coa_id')]
    public mixed $coa_id;

    #[MapInputName('journal_entry_id')]
    #[MapName('journal_entry_id')]
    public mixed $journal_entry_id;

    #[MapInputName('debit')]
    #[MapName('debit')]
    public ?int $debit;

    #[MapInputName('credit')]
    #[MapName('credit')]
    public ?int $credit;

    #[MapInputName('props')]
    #[MapName('props')]
    public ?array $props = null;

    public static function after(self $data): self{
        $new = static::new();

        $props = &$data->props;
        
        $coa = $new->CoaModel();
        $coa = (isset($data->coa_id)) ? $coa->findOrFail($data->coa_id) : $coa;
        $props['prop_coa'] = $coa->toViewApi()->only([
            'id', 'name', 'balance_type'
        ]);
        return $data;
    }
}