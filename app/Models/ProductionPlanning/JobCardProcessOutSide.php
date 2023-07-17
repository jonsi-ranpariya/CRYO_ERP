<?php

namespace App\Models\ProductionPlanning;

use App\Models\BaseModel;

class JobCardProcessOutSide extends BaseModel
{
//    protected $connection = 'mongodb';
    protected $collection = 'job_card_process_outside';
    protected $fillable = [
        'processId',
        'jobId',
        'OutSideSelectBatch',
        'OutSideSubContractorCode',
        'OutSideSubContractorName',
        'OutSideOperatorDate',
        'outSideChallanNo',
        'outSideIssueQty',
        'outSideTotalAvlQty',
        'outSideAcceptQty',
        'outSideRejectQty',
        'outSideProcessCost',
        'outSideRwQty',
        'outSideRemark',
    ];

}
