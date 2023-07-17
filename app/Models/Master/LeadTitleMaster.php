<?php

namespace App\Models\Master;

use App\Models\BaseModel;

class LeadTitleMaster extends BaseModel
{
    protected $collection = 'lead_title_masters';
    protected $fillable = [
        'leadTitle',
        'addedFrom',
        'companyId'
    ];
    protected $hidden = ['updated_at'];
}
