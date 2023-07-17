<?php

namespace App\Models\Despatch;

use App\Models\BaseModel;

class NewChallanInvoiceShipping extends BaseModel
{
    protected $collection = 'new_challan_invoice_shipping';

    protected $fillable = [
        'challanInvoiceId',
        'addedFrom',
        'updatedFrom',
        'companyId',
        'itemCode',
        'itemDescription',
        'itemAddDescription',
        'itemDetailDescription',
        'itemDrawingNumber',
        'itemDrawingRevision',
        'caseNo',
        'markAndNos',
        'totalQuantity',
        'totalNetWeight',
        'totalGsWeight',
        'dimOfBox',
    ];

    public function itemDetails()
    {
        return $this->hasOne(NewChallanInvoiceItems::class,'_id','itemCode');
    }
}
