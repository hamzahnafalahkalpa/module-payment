<?php

use Hanafalah\ModulePayment\Commands as ModulePaymentCommands;
use Hanafalah\ModulePayment\Contracts;

return [
    'commands' => [
        ModulePaymentCommands\InstallMakeCommand::class
    ],
    'libs' => [
        'model' => 'Models',
        'contract' => 'Contracts',
        'schema' => 'Schemas'
    ],
    'app' => [
        'contracts'  => [
        ],
    ],
    'database'   => [
        'models' => [

        ]
    ],
    'voucher' => [
        'benefit_targets' => [
            'benefit_billing'     => Contracts\Supports\Benefit\Billing::class,
        ],
        'conditions' => [
            'maximum_usage'       => Contracts\Supports\Condition\UsageCondition::class,
            'in_date_range'       => Contracts\Supports\Condition\DateCondition::class,
            'less_than_date'      => Contracts\Supports\Condition\DateCondition::class,
            'after_than_date'     => Contracts\Supports\Condition\DateCondition::class,
            'minimum_transaction' => Contracts\Supports\Condition\TransactionCondition::class
        ]
    ],
    'author' => \App\Models\User::class
];
