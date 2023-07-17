<?php

namespace App\Models\QualityControl;

use App\Models\BaseModel;
use App\Models\Partymaster\PartyMaster;
use App\Models\Purchase\PurchaseOrder;

class JobWorkOutsideQc extends BaseModel
{
//    protected $connection = 'mongodb';

    protected $collection = 'job_work_outside_qc';
    protected $fillable = [
        'subContractorCode',
        'subContractorName',
        'itemCode',
        'itemDescription',
        'itemAddDescription',
        'itemMake',
        'itemDetailDescription',
        'itemDrawingNo',
        'itemRev',
        'itemUom',
        'jobWorkNo',
        'jobCardNo',
        'workOrderNo',
        'challanNo',
        'challanDate',
        'itemStore',
        'challanQty',
        'acceptedQty',
        'rejectedQty',
        'reWorkQty',
        'inspectionDate',
        'rejectItemCode',
        'rejectItemDescription',
        'rejectItemRate',
        'rejectCost',
        'rejectItemQty',
        'rejectionTyp',
        'batchNo',
        'operatorName',
        'rejectionReason',
        'remark',
        'heatNo',
        'quantity',
        'manufacturedDate',
        'expiredDate',
        'batchRemark',
        'remarkDetails',
        'loginDetails',
        'addedFrom',
        'updatedFrom',
        'companyId'
    ];

    protected $appends = ['party_details'];
    public function partyDetails()
    {
        return $this->hasOne(PartyMaster::class,'_id','subContractorCode');
    }

    public function getPartyDetailsAttribute()
    {
        return $this->partyDetails()->first(['partyCode']);
    }

}
