<?php

namespace Hanafalah\ModulePayment\Data;

use Hanafalah\ModulePayment\Contracts\Data\CoaTypeData as DataCoaTypeData;

class CoaTypeData extends FinanceStuffData implements DataCoaTypeData
{
    public static function before(array &$attributes){
        $attributes['flag'] = 'CoaType';
    }
}