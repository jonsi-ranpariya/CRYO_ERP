<?php

namespace App\Models\Mrp;

use App\Models\BaseModel;

class DeliverySchedule extends BaseModel
{
    protected $collection = 'manual_planning_delivery_schedule';

    protected $fillable = [
        'manualPlanningId',
        'deliveryDate',
        'quantity',
        'totalQty',
        'poQty',
        'addedFrom',
        'updatedFrom',
        'companyId'
    ];
}
