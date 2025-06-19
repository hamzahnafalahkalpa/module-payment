<?php

namespace Hanafalah\ModulePayment\Resources\JournalEntry;

use Hanafalah\LaravelSupport\Resources\ApiResource;

class ViewJournalEntry extends ApiResource
{
  /**
   * Transform the resource into an array.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
   */
  public function toArray(\Illuminate\Http\Request $request): array
  {
    $arr = [
      'id'                       => $this->id,
      'name'                     => $this->name,
      'reference'                => $this->prop_reference,
      'transaction_reference_id' => $this->transaction_reference_id,
      'journal_source_id'        => $this->journal_source_id,
      'journal_source'           => $this->prop_journal_source,
      'reported_at'              => $this->reported_at,
      'status'                   => $this->status,
      'author'                   => $this->prop_author
    ];
    return $arr;
  }
}
