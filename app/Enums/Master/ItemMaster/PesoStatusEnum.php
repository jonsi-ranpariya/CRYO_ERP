<?php

namespace App\Enums\Master\ItemMaster;

use BenSampo\Enum\Enum;

final class PesoStatusEnum extends Enum
{
    const UNDER_APPROVAL = 'UNDER APPROVAL';
    const APPROVED = 'APPROVED';
    const NOT_APPROVED = 'NOT APPROVED';
    const NOT_APPLICABLE = 'NOT APPLICABLE';
}
