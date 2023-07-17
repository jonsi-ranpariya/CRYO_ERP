<?php

namespace App\Models\Finance;

use App\Models\BaseModel;

class CostCenterMaster extends BaseModel
{
    protected $collection = 'cost_center_master';
    protected $fillable = [
        'groupCode',
        'groupName',
        'isLastLevel',
        'parentGroupId',
        'companyId',
        'addedFrom'
    ];
    protected $hidden = ['updated_at'];
}
