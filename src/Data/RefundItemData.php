<?php

namespace Hanafalah\ModulePayment\Data;

use Hanafalah\ModulePayment\Contracts\Data\RefundItemData as DataRefundItemData;
use Hanafalah\ModuleTransaction\Data\TransactionItemData;

class RefundItemData extends TransactionItemData implements DataRefundItemData{}