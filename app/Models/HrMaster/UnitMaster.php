<?php

namespace App\Models\HrMaster;

use App\Models\BaseModel;

class UnitMaster extends BaseModel
{
    protected $collection = 'unit_master';
    protected $fillable = [
        'unit',
        'addedFrom',
        'updatedFrom',
        'companyId'
    ];
}
