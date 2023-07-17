<?php

namespace App\Models\Master;

use App\Models\BaseModel;

class TaskMaster extends BaseModel
{
    protected $collection = 'task_master';
    protected $fillable = [
        'taskName',
        'autoActivityAlert',
        'autoSmsAlert',
        'autoMailAlert',
        'requiredDays',
        'taskSubject',
        'taskMsgBody',
        'taskIntimationUser',
        'companyId',
        'addedFrom'
    ];
    protected $hidden = ['updated_at'];
}
