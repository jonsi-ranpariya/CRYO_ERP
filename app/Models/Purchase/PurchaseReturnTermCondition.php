<?php

namespace App\Models\Purchase;

use App\Models\BaseModel;

class PurchaseReturnTermCondition extends BaseModel
{
    protected $collection = 'purchase_return_term_condition';

    protected $fillable = [
        'purchaseReturnId',
        'groupId',
        'groupName',
        'termAndCondition',
        'addedFrom',
        'updatedFrom',
        'companyId',
    ];
}
