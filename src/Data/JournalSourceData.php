<?php

namespace Hanafalah\ModulePayment\Data;

use Hanafalah\ModulePayment\Contracts\Data\JournalSourceData as DataJournalSourceData;

class JournalSourceData extends FinanceStuffData implements DataJournalSourceData
{
    public static function before(array &$attributes){
        $attributes['flag'] ??= 'JournalSource';
        parent::before($attributes);
    }
}