<?php

namespace App\Models\QualityControl;

use App\Models\BaseModel;

class FinishedGoodQualityControl extends BaseModel
{
    protected $collection = 'finished_good_quality_control';
    protected $fillable = [
        'workOrderNo',
        'woDate',
        'woType',
        'partyCode',
        'itemCode',
        'itemDescription',
        'itemAddDescription',
        'itemMake',
        'itemDetailDescription',
        'itemDrawingNo',
        'itemRev',
        'itemUom',
        'woQty',
        'rate',
        'pendingQty',
        'completedQty',
        'jobCardNo',
        'inspectionDate',
        'acceptedQty',
        'rejectedQty',
        'batchNo',
        'remarkDetails',
        'loginDetails',
        'addedFrom',
        'updatedFrom',
        'companyId'
    ];
}
