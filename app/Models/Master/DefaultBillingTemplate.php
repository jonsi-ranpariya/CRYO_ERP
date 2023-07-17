<?php

namespace App\Models\Master;

use App\Models\BaseModel;

class DefaultBillingTemplate extends BaseModel
{
    protected $collection = 'default_billing_templates';
    protected $fillable = [
        'invoice',
        'purchaseOrder',
        'salesOrder',
        'addedFrom',
        'updatedFrom',
        'created_at',
        'updated_at',
        'companyId',
    ];
}
