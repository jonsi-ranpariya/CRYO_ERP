<?php

namespace App\Models\Master;

use App\Models\BaseModel;

class LeadStageMaster extends BaseModel
{
    protected $collection = 'lead_stage_masters';
    protected $fillable = [
        'leadStage',
        'stageType',
        'percentage',
        'srNo',
        'addedFrom',
        'companyId'
    ];
    protected $hidden = ['updated_at'];
}
