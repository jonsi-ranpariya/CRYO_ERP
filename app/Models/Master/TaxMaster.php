<?php

namespace App\Models\Master;

use App\Models\BaseModel;

class TaxMaster extends BaseModel
{
    protected $collection = 'tax_master';
    protected $fillable = [
        'taxDescription',
        'taxPercentage',
        'taxCredit',
        'companyId',
        'addedFrom'
    ];
    protected $hidden = ['updated_at'];
}
