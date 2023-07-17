<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

final class UserTypeEnums extends Enum
{
    const SUPER =   'SUPER-ADMIN';
    const ADMIN =   'ADMIN';
    const USER =   'USER';
    const HODADMIN =   'HOD-ADMIN';
    const EMPLOYEE =   'EMPLOYEE';

    const HRADMIN =   'HR-ADMIN';
}
