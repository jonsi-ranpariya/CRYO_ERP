<?php

namespace App\Models\Master;

use App\Models\BaseModel;

class OperatorMaster extends BaseModel
{
    protected $collection = 'operator_master';
    protected $fillable = [
        'operatorName',
        'companyId',
        'addedFrom'

    ];
    protected $hidden = ['updated_at'];
}
