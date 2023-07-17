<?php

namespace App\Models\Master;

use App\Models\BaseModel;

class BusinessTypeMaster extends BaseModel
{
    protected $collection = 'business_types';
    protected $fillable = [
        'businessType',
        'companyId',
        'addedFrom'

    ];
    protected $hidden = ['updated_at'];
}
