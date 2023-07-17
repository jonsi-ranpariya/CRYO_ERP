<?php

namespace App\Models\Master;

use App\Models\BaseModel;

class DutyDrawbackMaster extends BaseModel
{
    protected $collection = 'duty_drawback_master';
    protected $fillable = [
        'subHeadingDescription',
        'subHeadingNumber',
        'companyId',
        'addedFrom'
    ];
    protected $hidden = ['updated_at'];
}
