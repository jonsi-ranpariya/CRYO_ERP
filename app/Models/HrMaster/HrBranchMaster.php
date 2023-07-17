<?php

namespace App\Models\HrMaster;

use App\Models\BaseModel;

class HrBranchMaster extends BaseModel
{
    protected $collection = 'branch_master';
    protected $fillable = [
        'branch',
        'addedFrom',
        'updatedFrom',
        'companyId'
    ];
}
