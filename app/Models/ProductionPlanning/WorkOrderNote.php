<?php

namespace App\Models\ProductionPlanning;

use App\Models\BaseModel;

class WorkOrderNote extends BaseModel
{
    protected $collection = 'work_order_note';

    protected $fillable = [
        'woId',
        'groupId',
        'groupName',
        'description',
        'addedFrom',
        'updatedFrom',
    ];
}
