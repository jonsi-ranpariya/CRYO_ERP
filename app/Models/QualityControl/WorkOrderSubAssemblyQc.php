<?php

namespace App\Models\QualityControl;

use App\Models\BaseModel;

class WorkOrderSubAssemblyQc extends BaseModel
{
    protected $collection = 'work_order_sub_assembly_quality_control';
    protected $fillable = [
        'workOrderNo',
        'woDate',
        'woType',
        'partyCode',
        'partyName',
        'itemCode',
        'itemDescription',
        'itemAddDescription',
        'itemMake',
        'itemDetailDescription',
        'itemDrawingNo',
        'itemRev',
        'itemUom',
        'requiredQty',
        'rat',
        'pendingQty',
        'completedQty',
        'jobCardN',
        'inspectionDate',
        'acceptedQty',
        'rejectedQty',
        'batchNo',
        'remarkDetails',
        'loginDetails',
    ];
}
