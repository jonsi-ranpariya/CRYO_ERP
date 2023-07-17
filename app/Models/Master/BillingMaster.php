<?php

namespace App\Models\Master;

use App\Models\BaseModel;

class BillingMaster extends BaseModel
{
    protected $collection = 'billing_master';
    protected $fillable = [
        'name',
        'calCode',
        'valueType',
        'defaultValue',
        'addedFrom',
        'companyId',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
        'companyId'
    ];
}
