<?php

namespace App\Models\Despatch;

use App\Models\BaseModel;

class NewChallanInvoiceBillingTerm extends BaseModel
{
    protected $collection = 'new_challan_and_invoice_billing_term';

    protected $fillable = [
        'addedFrom',
        'updatedFrom',
        'companyId',
        'challanInvoiceId',
        'calCode',
        'calDefination',
        'description',
        'type',
        'byValue',
        'percentage',
        'total_amount',
        'operation',
        'calculateAmount',
        'srNo',
    ];
}
