<?php

namespace App\Models\Purchase;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseQuotationTermCondition extends BaseModel
{

    protected $collection = 'purchase_quotation_term_conditions';

    protected $fillable = [
        'purchaseQuotationId',
        'groupId',
        'groupDescription',
        'termsCondition',
        'addedFrom',
        'updatedFrom',
        'companyId',
    ];
}
