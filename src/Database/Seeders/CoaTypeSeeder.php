<?php

namespace Hanafalah\ModulePayment\Database\Seeders;

use Hanafalah\LaravelSupport\Concerns\Support\HasRequestData;
use Hanafalah\ModulePayment\Contracts\Data\CoaTypeData;
use Illuminate\Database\Seeder;

class CoaTypeSeeder extends Seeder{
    use HasRequestData;

    protected $__coa_types = [
        ['name' => 'Asset'],
        ['name' => 'Current Asset'],
        ['name' => 'Non-Current Asset'],
        ['name' => 'Liability'],
        ['name' => 'Current Liability'],
        ['name' => 'Non-Current Liability'],
        ['name' => 'Equity'],
        ['name' => 'Revenue'],
        ['name' => 'Expense'],
        ['name' => 'Other Income'],
        ['name' => 'Other Expense'],
        ['name' => 'Cost of Goods Sold'],
    ];

    public function run(): void
    {
        foreach ($this->__coa_types as $coa_type) {
            app(config('app.contracts.CoaType'))->prepareStoreCoaType($this->requestDTO(CoaTypeData::class, $coa_type));
        }
    }
}