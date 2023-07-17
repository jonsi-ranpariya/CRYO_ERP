<?php

namespace App\Models\SalesCrm;

use App\Models\BaseModel;

class SalesOrderChecklist extends BaseModel
{
    protected $collection = 'sales_order_checklist';
    protected $fillable = [
        'addedFrom',
        'updatedFrom',
        'created_at',
        'updated_at',
        'salesOrderId',
        'detailDescription',
        'remark',
        'checkedFor',
    ];
}
