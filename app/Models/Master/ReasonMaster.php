<?php

namespace App\Models\Master;

use App\Models\BaseModel;

class ReasonMaster extends BaseModel
{
    protected $collection = 'reason_masters';
    protected $fillable = [
        'reason',
        'reasonType',
        'companyId',
        'addedFrom',
    ];
    protected $hidden = ['updated_at'];
}
