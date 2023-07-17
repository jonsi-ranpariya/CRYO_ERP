<?php

namespace App\Models\JobWork;

use App\Models\BaseModel;
use App\Models\Master\ItemMaster;
use App\Models\Master\UnitMeasurment;

class IssueJobWorkChallanItems extends BaseModel
{

    protected $collection = 'issue_job_work_challan_item';

    protected $fillable = [
        'jobWorkId',
        'showIssueItemId',
        'itemId',
        'jobCardId',
        'itemCode',
        'itemDescription',
        'itemAddDescription',
        'itemDetailDescription',
        'itemDrawingNumber',
        'itemDrawingRevision',
        'itemUom',
        'itemQuntity',
        'issueItemQty',
        'jobCardNumber',
        'pendingJobQty',
        ];

    protected $appends = ['uom_details','item_name'];

    public function uomDetail()
    {
        return $this->hasOne(UnitMeasurment::class,'_id','itemUom');
    }

    public function getUomDetailsAttribute()
    {
        return $this->uomDetail()->first(['uom']);
    }

    public function itemDetail()
    {
        return $this->hasOne(ItemMaster::class,'_id','itemCode');
    }

    public function getItemNameAttribute()
    {
        return $this->itemDetail()->first(['itemCode','itemDescription']);
    }
}
