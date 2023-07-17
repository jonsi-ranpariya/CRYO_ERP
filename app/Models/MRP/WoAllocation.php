<?php

namespace App\Models\Mrp;

use App\Models\BaseModel;

class WoAllocation extends BaseModel
{
    protected $collection = 'manual_planning_wo_allocation';

    protected $fillable = [
        'manualPlanningId',
        'woId',
        'woNumber',
        'itemName',
        'itemReqQty',
        'addedFrom',
        'updatedFrom',
        'companyId',
    ];
}
