<?php

namespace App\Models\ProductionPlanning;

use App\Models\BaseModel;
use App\Models\Master\UnitMeasurment;

class JobCards extends BaseModel
{
    protected $collection = 'job_cards';
    protected $fillable = [
        'jobId',
        'itemId',
        'woNumber',
        'itemCode',
        'itemDescription',
        'jobCardNumber',
        'jobCardDate',
        'status',
        'completeDate',
        'itemMake',
        'addDescription',
        'detailDescription',
        'drawingNumber',
        'drawingRevesion',
        'uom',
        'convUom',
        'convQty',
        'cFactor',
        'bomNumber',
        'foreCastNo',
        'priority',
        'quantityUm',
        'quantityUp',
        'refNo',
        'msnNo',
        'jobCard',
        'jobQty',
        'pendingJobQty',
        'acceptedQty',
        'rwQty',
        'rejectedQty',
        'scQty',
        'heatBatchNo',
        'processSheetNo',
        'remark',
        'selectBatch',
        'scrapDetails',
        'loginDetails',
        'addedFrom',
        'updatedFrom',
        'companyId',
    ];
    protected $appends = ['uom_details','process_details'];

    public function uomDetail()
    {
        return $this->hasOne(UnitMeasurment::class,'_id','uom');
    }

    public function getUomDetailsAttribute()
    {
        return $this->uomDetail()->first(['uom']);
    }

    public function processDetails()
    {
        return $this->hasOne(JobCardProcessDetails::class,'jobId', '_id');
    }

    public function getProcessDetailsAttribute()
    {
       return $this->processDetails()->first(['process','processDescription']);
    }

}
