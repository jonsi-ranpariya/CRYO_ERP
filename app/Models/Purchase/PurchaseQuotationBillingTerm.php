<?php

namespace App\Models\Purchase;

use App\Models\BaseModel;

class PurchaseQuotationBillingTerm extends BaseModel
{
    protected $collection = 'purchase_quotation_billing_terms';

    protected $fillable = [
        'purchaseQuotationId',
        'byValue',
        'calCode',
        'calCodeLabel',
        'calDefination',
        'calculateAmount',
        'description',
        'narration',
        'operation',
        'percentage',
        'type',
        'srNo',
        'addedFrom',
        'updatedFrom',
        'companyId',
    ];

    public function purchaseQoutation()
    {
        return $this->belongsTo(PurchaseQuotation::class,'_id','purchaseQuotationId');
    }
}
