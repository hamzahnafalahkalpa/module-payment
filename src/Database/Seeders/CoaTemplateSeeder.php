<?php

namespace Hanafalah\ModulePayment\Database\Seeders;

use Hanafalah\LaravelSupport\Concerns\Support\HasRequestData;
use Illuminate\Database\Seeder;

class CoaTemplateSeeder extends Seeder
{
    use HasRequestData;

    public function run(): void
    {
        $coa_templates = [
            [
                'id' => 'Template Utama'
            ]
        ];
        foreach ($coa_templates as $coa) {
            app(config('app.contracts.CoaTemplate'))->prepareStoreCoa($this->requestDTO(config('app.contracts.CoaTemplateData'), $coa));
        }
    }
}
