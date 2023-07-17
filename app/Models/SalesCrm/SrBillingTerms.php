<?php

namespace App\Models\SalesCrm;

use App\Models\BaseModel;

class SrBillingTerms extends BaseModel
{
    protected $collection = 'sr_billing_terms';
    protected $fillable = [
        'salesReturnId',
        'calCode',
        'calCodeLabel',
        'description',
        'calDefination',
        'percentage',
        'byValue',
        'operation',
        'narration',
        'type',
        'total_amount',
        'srNo',
        'addedFrom',
        'updatedFrom',
        'created_at',
        'updated_at',
        'companyId',
    ];

    protected $hidden = ['updated_at'];
}
