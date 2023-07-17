<?php

namespace App\Models\JobWork;

use App\Models\BaseModel;

class ScrapReceiptEntry extends BaseModel
{
    protected $collection = 'scrap_receipt_entry';
    protected $fillable = [
        'grnNo',
        'grnDate',
        'itemId',
        'itemCode',
        'itemDescription',
        'itemAddDescription',
        'itemDetailDescription',
        'itemDrawingNo',
        'itemRevision',
        'itemUom',
        'subContractorId',
        'subContractor',
        'subContractorName',
        'itemJobWorkNo',
        'challanNo',
        'challanDate',
        'challanQty',
        'expectedScrap',
        'scrapReceived',
        'rate',
        'scrapCode',
        'scrapName',
        'addedFrom',
        'updatedFrom',
        'companyId'
    ];
//    public function jobWorkDetails()
//    {
//        return $this->hasOne(ScrapReceiptEntry::class,'_id', 'itemJobWorkNo');
//    }
}
