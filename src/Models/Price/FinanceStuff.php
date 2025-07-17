<?php

namespace Hanafalah\ModulePayment\Models\Price;

use Hanafalah\LaravelSupport\Models\Unicode\Unicode;
use Hanafalah\ModulePayment\Resources\FinanceStuff\{
    ViewFinanceStuff,
    ShowFinanceStuff
};

class FinanceStuff extends Unicode
{
    protected $table = 'unicodes';

    public function getViewResource(){return ViewFinanceStuff::class;}
    public function getShowResource(){return ShowFinanceStuff::class;}
}
