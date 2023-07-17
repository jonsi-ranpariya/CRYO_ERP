<?php

namespace App\Models\Master;

use App\Models\BaseModel;

class IndustryTypeMaster extends BaseModel
{
    protected $collection = 'industries_type_masters';
    protected $fillable = [
        'industryType',
        'addedFrom',
        'companyId',
    ];
    protected $hidden = ['updated_at'];
}
