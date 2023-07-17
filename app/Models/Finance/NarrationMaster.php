<?php

namespace App\Models\Finance;

use App\Models\BaseModel;

class NarrationMaster extends BaseModel
{
    protected $collection = 'narration_master';
    protected $fillable = [
        'narration',
        'companyId',
        'addedFrom'
    ];
    protected $hidden = ['updated_at'];
}
