<?php

namespace App\Models\JobWork;

use App\Models\BaseModel;
use App\Models\Master\ProcessMaster;

class JobWorkRateMasterProcess extends BaseModel
{

    protected $collection = 'job_work_rate_process';

    protected $fillable = [
        'RateProcessId',
        'itemProcess',
        'processDescription',
        'processRate',
        'rateTolerance',
        'leadTime',
        'addedFrom',
        'updatedFrom',
        'companyId',
    ];

}
