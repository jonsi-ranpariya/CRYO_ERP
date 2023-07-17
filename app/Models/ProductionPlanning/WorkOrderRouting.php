<?php

namespace App\Models\ProductionPlanning;

use App\Models\BaseModel;

class WorkOrderRouting extends BaseModel
{
    protected $collection = 'work_order_routing';

    protected $fillable = [
        'woId',
        'description',
        'addedFrom',
        'updatedFrom',
        'companyId',
    ];
}
