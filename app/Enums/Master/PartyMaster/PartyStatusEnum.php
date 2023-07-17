<?php

namespace App\Enums\Master\PartyMaster;

use BenSampo\Enum\Enum;

final class PartyStatusEnum extends Enum
{
    const Created = 'Created';
    const Trial = 'Trial';
    const Approved = 'Approved';
    const Rejected = 'Rejected';
}
