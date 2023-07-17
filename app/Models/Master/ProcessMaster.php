<?php

namespace App\Models\Master;

use App\Models\BaseModel;

class ProcessMaster extends BaseModel
{
    protected $collection = 'process_master';
    protected $fillable = [
        'processName',
        'userForQc',
        'companyId',
        'addedFrom'
    ];
    protected $hidden = ['updated_at'];
}
