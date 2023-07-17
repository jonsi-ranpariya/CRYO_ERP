<?php

namespace App\Models\JobWork;

use App\Models\BaseModel;

class JobWorkRateTermsCondition extends BaseModel
{

    protected $collection = 'job_work_team_condition';

    protected $fillable = [
        'jobRateId',
        'groupId',
        'groupDescription',
        'termsCondition',
        'addedFrom',
        'updatedFrom',
        'companyId',
    ];
}
