<?php

namespace App\Models\JobWork;

use App\Models\BaseModel;
use App\Models\Master\ProcessMaster;
use App\Models\Master\UnitMeasurment;


class JobWorkOrderItems extends BaseModel
{

    protected $collection = 'job_work_order_item';

    protected $fillable = [
        'jobWorkId',
        'itemId',
        'itemCode',
        'itemDescription',
        'itemAlice',
        'itemAddDescription',
        'itemDetailDescription',
        'itemDrawingNumber',
        'itemDrawingRevision',
        'itemUom',
        'itemConvUom',
        'itemConvQty',
        'itemcFactor',
        'itemProcess',
        'itemProcessRate',
        'itemProcessAmt',
        'itemProcessNote',
        'itemJobCardNumber',
        'itemWoNumber',
        'itemDelDate',
        'itemNote',
        'itemJobWorkQty',
        'itemAcctQty',
        'itemPendingQty',
        'itemRejectedQty',
        'itemEstValue',
        'itemRwQty',
        'itemInternalNote',

    ];
    protected $appends = ['uom_details'];

    public function uomDetail()
    {
        return $this->hasOne(UnitMeasurment::class, '_id', 'itemUom');
    }

    public function getUomDetailsAttribute()
    {
        return $this->uomDetail()->first(['uom']);
    }

    public function jobWorkDetails()
    {
        return $this->hasOne(JobWorkOrder::class, '_id', 'jobWorkId');
    }

    public function processDetails()
    {
        return $this->hasOne(ProcessMaster::class, '_id', 'itemProcess');
    }

    public function scopeWithJobWorkDetails($query)
    {
        return $query->with(["jobWorkDetails" => function ($q) {
            $q->select([
                '_id',
                'jobWorkNo',
                'jobWorkDate',
                'subContractorId',
                'subContractorCode',
                'subContractorName',
                'status',
                'isExcisable',
                'jwType',
                'rounding',
                'subContractorDetails',
            ]);
        }]);
    }

    public function scopeWithProcessDetails($query)
    {
        return $query->with(['processDetails' => function ($q) {
            $q->select([
                '_id',
                'processName',
            ]);
        }]);
    }
}
