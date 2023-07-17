<?php

namespace App\Models\Master;

use App\Models\BaseModel;

class BranchMaster extends BaseModel
{
    protected $collection = 'branch_master';
    protected $fillable = [
        'branchName',
        'companyId',
        'addedFrom'

    ];
    protected $hidden = ['updated_at'];
}
