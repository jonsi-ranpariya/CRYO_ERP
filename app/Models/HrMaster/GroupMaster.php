<?php

namespace App\Models\HrMaster;

use App\Models\BaseModel;

class GroupMaster extends BaseModel
{
    protected $collection = 'group_master';
    protected $fillable = [
        'group',
        'addedFrom',
        'updatedFrom',
        'companyId'
    ];
}
