<?php

namespace App\Enums\Master\ItemMaster;

use BenSampo\Enum\Enum;

final class StatusEnum extends Enum
{
    const In_Use = 1;
    const Hold_For_Despatch = 2;
    const Phased_Out = 3;
}
