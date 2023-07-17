<?php

namespace App\Models\HrMaster;

use App\Models\BaseModel;

class HrDesignationMaster extends BaseModel
{
    protected $collection = 'designation_master';
    protected $fillable = [
        'designation',
        'addedFrom',
        'updatedFrom',
        'companyId'
    ];
}
