<?php

namespace App\Models\SalesCrm;

use App\Models\BaseModel;

class SalesOrderBillingTerms extends BaseModel
{
    protected $collection = 'sales_order_billing_terms';
    protected $fillable = [
        'salesOrderId',
        'billingId',
        'billingName',
        'billingType',
        'billingPercentage',
        'billingValue',
        'billingNarration',
        'calCode',
        'calCodeLabel',
        'calDefination',
        'calculatedAmount',
        'srNo',
        'companyId',
        'addedFrom',
        'updatedFrom',
    ];

    protected $hidden = ['updated_at'];
}
