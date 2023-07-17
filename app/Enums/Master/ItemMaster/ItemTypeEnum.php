<?php

namespace App\Enums\Master\ItemMaster;

use BenSampo\Enum\Enum;

final class ItemTypeEnum extends Enum
{
    const Sales = 1;
    const Purchase = 2;
    const General = 3;
    const Service = 4;
}
