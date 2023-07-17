<?php

namespace App\Models\SalesCrm;

use App\Models\BaseModel;

class PiBillingTerms extends BaseModel
{
    protected $collection = 'pi_billing_terms';
    protected $fillable = [
        'pInvoiceId',
        'calCode',
        'calCodeLabel',
        'calDefination',
        'billingId',
        'billingName',
        'billingType',
        'billingPercentage',
        'billingValue',
        'billingNarration',
        'calculatedAmount',
        'companyId',
        'addedFrom',
        'updatedFrom',
    ];

    protected $hidden = ['updated_at'];
}
