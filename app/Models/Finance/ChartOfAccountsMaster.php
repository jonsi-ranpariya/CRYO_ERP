<?php

namespace App\Models\Finance;

use App\Models\BaseModel;

class ChartOfAccountsMaster extends BaseModel
{
    protected $collection = 'chart_of_account_master';
    protected $fillable = [
        'groupCode',
        'groupName',
        'isLastLevel',
        'sequenceNo',
        'parentGroupId',
        'companyId',
        'addedFrom'
    ];
    protected $hidden = ['updated_at'];
}
