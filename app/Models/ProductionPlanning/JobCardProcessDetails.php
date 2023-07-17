<?php

namespace App\Models\ProductionPlanning;

use App\Models\BaseModel;
use App\Models\Master\ProcessMaster;
use App\Models\Master\TermsConditionGroupMaster;
use Jenssegers\Mongodb\Relations\HasOne;

class JobCardProcessDetails extends BaseModel
{
    protected $collection = 'job_card_process_details';

    protected $fillable = [
        'processId',
        'processItemId',
        'processSheetId',
        'bomId',
        'jobId',
        'machineNumber',
        'process',
        'processDescription',
        'operator',
        'quantity',
        'pendingQty',
        'acceptedQty',
        'rejectedQty',
        'rwQty',
        'inspInstruction',
        'inspectionBy',
        'inspectionLevel',
        'specialTool',
        'wtLoss',
        'matWt',
        'scrapTolerance',
        'noOfHr',
        'remark',
        'setupTimeInMinute',
        'processTimeInMinute',
        'userDetail',
        'LoginData',
        'addedFrom',
        'updatedFrom',
        'companyId',
    ];

    public function processDetail()
    {
        return $this->hasOne(ProcessMaster::class, '_id','processDescription');
    }
}
