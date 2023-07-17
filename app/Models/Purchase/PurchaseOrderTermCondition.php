<?php

namespace App\Models\Purchase;

use App\Models\BaseModel;
use App\Models\Master\TermsConditionDetailsMaster;

class PurchaseOrderTermCondition extends BaseModel
{

    protected $collection = 'purchase_order_term_conditions';

    protected $fillable = [
        'purchaseOrderId',
        'groupId',
        'groupName',
        'termsCondition',
        'addedFrom',
        'updatedFrom',
        'companyId',
    ];
}
