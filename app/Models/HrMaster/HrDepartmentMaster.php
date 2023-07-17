<?php

namespace App\Models\HrMaster;

use App\Models\BaseModel;

class HrDepartmentMaster extends BaseModel
{
    protected $collection = 'department_master';
    protected $fillable = [
        'department',
        'addedFrom',
        'updatedFrom',
        'companyId'
    ];
}
