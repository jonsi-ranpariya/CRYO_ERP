<?php

namespace App\Models\Master;

use App\Models\BaseModel;

class ProgressStageMaster extends BaseModel
{
    protected $collection = 'progress_stage_master';
    protected $fillable = [
        'stageFor',
        'stageStatus',
        'requiredDays',
        'responsibleUser',
        'stageRemark',
        'companyId',
        'addedFrom'
    ];
    protected $hidden = ['updated_at'];
}
