<?php

namespace App\Models\JobWork;

use App\Models\BaseModel;
use App\Models\Partymaster\PartyMaster;

class JobWorkReWorkReceipt extends BaseModel
{
    protected $collection = 'job_work_rework_receipt';
    protected $fillable = [
        'partyCode',
        'partyName',
        'itemId',
        'jobReWorkId',
        'jobReWorkItemId',
        'jobWorkId',
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
        'rate',
        'scrapCode',
        'scrapName',
        'loginDetails',
        'addedFrom',
        'updatedFrom',
        'companyId'
    ];
    public function partyDetails()
    {
        return $this->hasOne(PartyMaster::class,'_id', 'partyCode');
    }
}
