<?php

namespace App\Models\JobWork;

use App\Models\BaseModel;
use App\Models\Master\UnitMeasurment;

class JobWorkReWorkChallanItem extends BaseModel
{

    protected $collection = 'job_rework_challan_item';
    protected $fillable = [
        'jobReWorkId',
        'jobWorkId',
        'jobWorkItemId',
        'itemId',
        'itemCode',
        'itemDescription',
        'itemAddDescription',
        'itemDetailDescription',
        'itemDrawingNumber',
        'itemDrawingRevision',
        'itemUom',
        'itemQuntity',
        'itemPendingQty'
    ];
    protected $appends = ['uom_details'];

    public function uomDetail()
    {
        return $this->hasOne(UnitMeasurment::class,'_id','itemUom');
    }

    public function getUomDetailsAttribute()
    {
        return $this->uomDetail()->first(['uom']);
    }
}
