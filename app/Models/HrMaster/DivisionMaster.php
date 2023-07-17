<?php

namespace App\Models\HrMaster;

use App\Models\BaseModel;

class DivisionMaster extends BaseModel
{
    protected $collection = 'division_master';
    protected $fillable = [
        'division',
        'addedFrom',
        'updatedFrom',
        'companyId'

    ];
}
