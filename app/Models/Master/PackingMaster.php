<?php

namespace App\Models\Master;

use App\Models\BaseModel;

class PackingMaster extends BaseModel
{
    protected $collection = 'packing_master';
    protected $fillable = [
        'packingDesc',
        'companyId',
        'addedFrom'

    ];
    protected $hidden = ['updated_at'];
}
