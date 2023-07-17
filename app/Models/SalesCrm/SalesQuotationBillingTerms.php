<?php

namespace App\Models\SalesCrm;

use App\Models\BaseModel;

class SalesQuotationBillingTerms extends BaseModel
{
    protected $collection = 'sales_quotation_billing_terms';

    protected $fillable = [
        'salesQuotationId',
        'calCode',
        'calCodeLabel',
        'description',
        'calDefination',
        'operation',
        'percentage',
        'calculateAmount',
        'byValue',
        'narration',
        'templateId',
        'partyId',
        'type',
        'srNo',
    ];
}
