<?php

namespace App\Models\JobWork;

use App\Models\BaseModel;

class ReturnRejectionBillingTerm extends BaseModel
{
    protected $collection = 'return_rejection_memo_billing_term';

    protected $fillable = [
        'returnRejectMemoId',
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
        'updateFrom',
        'companyId'
    ];
}
