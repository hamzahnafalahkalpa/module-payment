<?php

namespace Hanafalah\ModulePayment\Resources\JournalEntry;

class ShowJournalEntry extends ViewJournalEntry
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
      'reference'   => $this->relationValidation('reference',function(){
        return $this->reference->toShowApi()->resolve();
      }),
      'coa_entries' => $this->relationValidation('coaEntries',function(){
        return $this->coaEntries->transform(function($coaEntry){
          return $coaEntry->toViewApi()->resolve();
        });
      })
    ];
    $arr = $this->mergeArray(parent::toArray($request),$arr);
    return $arr;
  }
}
