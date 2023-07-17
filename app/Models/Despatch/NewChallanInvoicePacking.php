<?php

namespace App\Models\Despatch;

use App\Models\BaseModel;
use App\Models\Master\ItemMaster;
use App\Models\Despatch\NewChallanInvoice;
use App\Models\Despatch\NewChallanInvoiceItems;

class NewChallanInvoicePacking extends BaseModel
{
    protected $collection = 'new_challan_invoice_packing';

    protected $fillable = [
        'challanInvoiceId',
        'itemCode',
        'itemDescription',
        'itemAddDescription',
        'itemDetailDescription',
        'msnNumber',
        'custPartNo',
        'caseNo',
        'markAndNos',
        'totalQuantity',
        'totalNetWeight',
        'totalGsWeight',
        'dimOfBox',
        'addedFrom',
        'updatedFrom',
        'companyId',
    ];

    public function challanDetails()
    {
        return $this->hasOne(NewChallanInvoice::class,'_id','challanInvoiceId');
    }

    public function itemDetails()
    {
        return $this->hasOne(NewChallanInvoiceItems::class,'_id','itemCode');
    }
}
