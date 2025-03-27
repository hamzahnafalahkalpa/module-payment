
    <?php

    namespace Hanafalah\ModulePayment\Enums\Billing;

    enum PaymentMethodEnum: string
    {
        case EDC      = 'EDC';
        case CASH     = 'CASH';
        case TRANSFER = 'TRANSFER';
        case DITAGIHKAN = 'DITAGIHKAN';
    }
