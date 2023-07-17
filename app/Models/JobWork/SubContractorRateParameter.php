<?php

namespace App\Models\JobWork;

use App\Models\BaseModel;

class SubContractorRateParameter extends BaseModel
{

    protected $collection = 'sub_contractor_rate_parameters';
    protected $fillable = [
        'formDay',
        'toDay',
        'percentages',
        'flag',
        'formPercentage',
        'toPercentage',
        'percentage',
        'flag',
        'addedFrom',
        'updatedFrom',
        'companyId'
    ];
}
