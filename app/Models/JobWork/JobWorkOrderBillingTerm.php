<?php

namespace App\Models\JobWork;

use App\Models\BaseModel;

class JobWorkOrderBillingTerm extends BaseModel
{
    protected $collection = 'job_work_order_billing_term';

    protected $fillable = [
        'calCode',
        'calCodeLabel',
        'calDefination',
        'description',
        'percentage',
        'byValue',
        'operation',
        'narration',
        'type',
        'total_amount',
        'srNo',
        'addedFrom',
        'updatedFrom',
        'companyId',
        'jobWorkOrderId',
    ];
}
