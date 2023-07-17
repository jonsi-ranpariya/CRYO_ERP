<?php

namespace App\Enums\Master\ItemMaster;

use BenSampo\Enum\Enum;

final class MaterialProcessTypeEnum extends Enum
{
    const process_in_house = 1;
    const procured = 2;
    const sub_contracting = 3;
}
