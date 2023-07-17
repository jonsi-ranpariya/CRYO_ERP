<?php

namespace App\Enums\Inventory;

use BenSampo\Enum\Enum;
final class TransactionTypeEnum extends Enum
{
    const Opening_Stock = 'Opening Stock';
    const Receipt = 'Receipt';
    const Issue = 'Issue';
    const Return = 'Return';
    const Rejection = 'Rejection(Shop)';
}
