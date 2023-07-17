<?php

namespace App\Models\JobWork;

use App\Models\BaseModel;
use App\Models\Partymaster\PartyMaster;

class ReceiptJobWorkChallan extends BaseModel
{

    protected $collection = 'receipt_job_work_challan';

    protected $fillable = [
        'partyCode',
        'partyName',
        'subContractorId',
        'itemId',
        'itemCode',
        'itemDescription',
        'itemAddDescription',
        'itemDetailDescription',
        'itemDrawingNo',
        'itemRevision',
        'itemUom',
        'subContractor',
        'subContractorName',
        'itemJobWorkNo',
        'itemJobCardNo',
        'itemWoNumber',
        'challanNo',
        'challanDate',
        'girNo',
        'girDate',
        'itemMake',
        'itemStore',
        'receiptNote',
        'jobQty',
        'pendingJobQty',
        'challanQty',
        'grnNo',
        'grnDate',
        'expectedScrap',
        'scrapReceived',
        'scrapCode',
        'scrapName',
        'rate',
        'loginDetails',
        'addedFrom',
        'updatedFrom',
        'companyId'

    ];
    public function partyDetails()
    {
        return $this->hasOne(PartyMaster::class,'_id', 'partyCode');
    }
    public function jobWorkDetail()
    {
        return $this->hasOne(ReceiptJobWorkChallan::class,'_id','itemJobWorkNo');
    }
}
