<?php

namespace App\Models\Master;

use App\Models\BaseModel;

class SalesOrderTypeMaster extends BaseModel
{

    protected $collection = 'sales_order_type_master';
    protected $fillable = [
        'description',
        'soInitial',
        'soCurrentNo',
        'woInitial',
        'woCurrentNo',
        'companyId',
        'addedFrom',
        'updatedFrom',
    ];

    protected $hidden = ['updated_at'];
}
