<?php

namespace App\Models\QualityControl;

use App\Models\BaseModel;
use App\Models\Inventory\Transaction;
use Jenssegers\Mongodb\Relations\MorphMany;

class JobCardProcessInsideQc extends BaseModel
{
    protected $collection = 'job_card_Process_inside_qc';
    protected $fillable = [
        'itemCode',
        'itemDescription',
        'itemAddDescription',
        'itemMake',
        'itemDetailDescription',
        'itemDrawingNo',
        'itemRev',
        'itemUom',
        'jobCardNo',
        'jobCardDate',
        'workOrderNo',
        'receiptDate',
        'itemStore',
        'pendingInspectonQty',
        'okQty',
        'acceptedQty',
        'rejectedQty',
        'reWorkQty',
        'inspectionDate',
        'rejectItemCode',
        'rejectItemDescription',
        'rejectItemRate',
        'rejectCost',
        'rejectItemQty',
        'rejectionType',
        'batchNo',
        'operatorName',
        'rejectionReason',
        'remark',
        'remarkDetails',
        'loginDetails',
        'addedFrom',
        'updatedFrom',
        'companyId'
    ];

    public function transactions(): MorphMany
    {
        return $this->morphMany(related: Transaction::class, name: 'transactionable', localKey: '_id');
    }
}
