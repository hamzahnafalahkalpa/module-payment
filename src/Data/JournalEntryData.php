<?php

namespace Hanafalah\ModulePayment\Data;

use Carbon\Carbon;
use Hanafalah\LaravelSupport\Supports\Data;
use Hanafalah\ModulePayment\Contracts\Data\JournalEntryData as DataJournalEntryData;
use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Attributes\MapName;

class JournalEntryData extends Data implements DataJournalEntryData
{
    #[MapInputName('id')]
    #[MapName('id')]
    public mixed $id = null;

    #[MapInputName('reference_type')]
    #[MapName('reference_type')]
    public string $reference_type;

    #[MapInputName('reference_id')]
    #[MapName('reference_id')]
    public mixed $reference_id;

    #[MapInputName('transaction_reference_id')]
    #[MapName('transaction_reference_id')]
    public mixed $transaction_reference_id;

    #[MapInputName('journal_source_id')]
    #[MapName('journal_source_id')]
    public mixed $journal_source_id;

    #[MapInputName('name')]
    #[MapName('name')]
    public ?string $name = null;

    #[MapInputName('reported_at')]
    #[MapName('reported_at')]
    public ?Carbon $reported_at = null;

    #[MapInputName('status')]
    #[MapName('status')]
    public ?string $status = 'DRAFT';

    #[MapInputName('author_type')]
    #[MapName('author_type')]
    public ?string $author_type = null;

    #[MapInputName('author_id')]
    #[MapName('author_id')]
    public ?string $author_id = null;

    #[MapInputName('props')]
    #[MapName('props')]
    public ?array $props = null;

    public static function before(array &$attributes){
        if (!isset($attributes['id'])) $attributes['status'] = app(config('database.models.JournalEntry'))::STATUS_DRAFT;
    }

    public static function after(self $data): self{
        $new = static::new();
        $props = &$data->props;

        $author = $new->{config('module-payment.author').'Model'}();
        $author = (isset($data->author_id)) ? $author->findOrFail($data->author_id) : $author;
        $props['prop_author'] = $author->toViewApi()->only(['id', 'name']);

        $journal_source = $new->JournalSourceModel();
        $journal_source = (isset($data->journal_source_id)) ? $author->findOrFail($data->journal_source_id) : $journal_source;
        $props['prop_journal_source'] = $journal_source->toViewApi()->only([
            'id', 'name', 'flag',
        ]);
        return $data;
    }
}