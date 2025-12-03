<?php

namespace Hanafalah\ModulePayment\Resources\JournalBatch;

use Hanafalah\LaravelSupport\Resources\ApiResource;

class ViewJournalBatch extends ApiResource
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
      'id' => $this->id,
      'reference_type' => $this->reference_type,
      'reference_id' => $this->reference_id,
      'reported_at' => $this->reported_at,
      'note' => $this->note,
      'status' => $this->status,
      'author_type' => $this->author_type,
      'author_id' => $this->author_id,
    ];
    return $arr;
  }
}
