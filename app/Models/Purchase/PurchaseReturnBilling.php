<?php

namespace App\Models\Purchase;


use App\Models\BaseModel;

class PurchaseReturnBilling extends BaseModel
{
    protected $collection = 'purchase_return_billing_term';

    protected $fillable = [
        'purchaseReturnId',
        'calCode',
        'calCodeLabel',
        'calDefination',
        'percentage',
        'byValue',
        'operation',
        'narration',
        'type',
        'total_amount',
        'srNo',
        'description',
        'addedFrom',
        'UpdateFrom',
        'CompanyId',
    ];
}
