<?php

namespace App\Models\Purchase;

use App\Models\BaseModel;

class PurchaseOrderBillingTerm extends BaseModel
{
    protected $collection = 'purchase_order_billing_term';

    protected $fillable = [
        'purchaseOrderId',
        'calCode',
        'calCodeLabel',
        'calDefination',
        'type',
        'byValue',
        'percentage',
        'narration',
        'operation',
        'calculateAmount',
        'description',
        'addedFrom',
        'updatedFrom',
        'companyId',
    ];
}
