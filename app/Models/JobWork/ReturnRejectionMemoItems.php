<?php


namespace App\Models\JobWork;

use App\Models\BaseModel;
use App\Models\Master\ItemMaster;
use App\Models\Master\UnitMeasurment;

class ReturnRejectionMemoItems extends BaseModel
{

    protected $collection = 'return_rejection_memo_item';
    protected $fillable = [
        'memoId',
        'issueJobWorkChallanId',
        'itemId',
        'showIssueItemId',
        'jobCardId',
        'itemCode',
        'itemDescription',
        'itemAddDescription',
        'itemDetailDescription',
        'itemDrawingNumber',
        'itemDrawingRevision',
        'itemUom',
        'itemProcess',
        'itemNote',
        'itemGirNo',
        'itemGirDate',
        'itemQuantity',
        'itemRate',
        'itemAmount',
        'itemReasons',
        'rejectionItemCode',
        'rejectItemDescription',
        'rejectItemRate',
    ];
    protected $appends = ['issue_item','uom_details'];

    public function uomDetail()
    {
        return $this->hasOne(UnitMeasurment::class,'_id','itemUom');
    }

    public function getUomDetailsAttribute()
    {
        return $this->uomDetail()->first(['uom']);
    }

    public function issueJobWorkDetailS()
    {
        return $this->hasOne(IssueJobWorkChallanItems::class,'_id','itemCode');
    }

    public function getIssueItemAttribute()
    {
        return $this->issueJobWorkDetailS()->first(['itemCode','itemDescription']);
    }
}
