<?php

namespace App\Models\Master;

use App\Models\BaseModel;

class MachineMaster extends BaseModel
{
    protected $collection = 'machine_master';
    protected $fillable = [
        'machineName',
        'companyId',
        'addedFrom'

    ];
    protected $hidden = ['updated_at'];
}
