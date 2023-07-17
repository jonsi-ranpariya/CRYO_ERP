<?php

namespace App\Models\HrMaster;

use App\Models\BaseModel;

class GradeMaster extends BaseModel
{
    protected $collection = 'grade_master';
    protected $fillable = [
        'grade',
        'addedFrom',
        'updatedFrom',
        'companyId'
    ];
}
