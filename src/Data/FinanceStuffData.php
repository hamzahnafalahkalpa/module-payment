<?php

namespace Hanafalah\ModulePayment\Data;

use Hanafalah\LaravelSupport\Data\UnicodeData;
use Hanafalah\ModulePayment\Contracts\Data\FinanceStuffData as DataFinanceStuffData;

class FinanceStuffData extends UnicodeData implements DataFinanceStuffData
{
    public static function before(array &$attributes){
        $attributes['flag'] ??= 'FinanceStuff';
        parent::before($attributes);
    }
}