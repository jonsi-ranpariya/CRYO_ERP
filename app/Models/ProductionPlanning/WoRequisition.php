<?php

namespace App\Models\ProductionPlanning;

use App\Models\BaseModel;

class WoRequisition extends BaseModel
{
    protected $collection = 'wo_requisition';

    protected $fillable = [
        'addedFrom',
        'updatedFrom',
        'companyId',
        'reqNumber',
        'woNumber',
        'woDate',
        'jobCardId',
        'jobCardNumber',
        'reqType',
        'LoginData',
    ];

    public function workOrderDetails()
    {
        return $this->hasOne(WorkOrder::class, 'woNumber', 'woNumber')->with('salesOrder');
    }

    public function jobCardDetails()
    {
        return $this->hasOne(JobCards::class,'_id','jobCardId');
    }
}
