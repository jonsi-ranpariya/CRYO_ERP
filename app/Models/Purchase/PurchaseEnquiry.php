<?php

namespace App\Models\Purchase;

use App\Models\BaseModel;

class PurchaseEnquiry extends BaseModel
{
    protected $collection = 'purchase_enquiry';

    protected $fillable = [
        'referenceNumber',
        'referenceDate',
        'dueDate',
        'validUpTo',
        'loginDetails',
        'headerFooterDetails',
        'remarkDetails',
        'addedFrom',
        'updatedFrom',
        'companyId'
    ];
}
