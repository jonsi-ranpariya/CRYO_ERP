<?php

namespace App\Models\ProductionPlanning;

use App\Models\BaseModel;

class WorkOrderItemRouting extends BaseModel
{
    protected $collection = 'work_order_item_routing';

    protected $fillable = [
        'woId',
        'itemId',
        'description',
        'addedFrom',
        'updatedFrom',
        'companyId',
    ];
}
