<?php

namespace App\Models\Master;

use App\Models\BaseModel;

class StateMaster extends BaseModel
{
    protected $collection = 'state_masters';
    protected $fillable = [
        'state',
        'stateCode',
        'country',
        'region',
        'supplyType',
        'addedFrom',
        'companyId',
    ];
}
