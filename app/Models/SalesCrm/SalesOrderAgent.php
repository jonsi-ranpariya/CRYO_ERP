<?php

namespace App\Models\SalesCrm;

use App\Models\BaseModel;

class SalesOrderAgent extends BaseModel
{
    protected $collection = 'sales_order_agents';
    protected $fillable = [
        'salesOrderId',
        'salesAgent',
        'salesOffice',
        'commPercentage',
        'commValue',
        'remark',
        'addedFrom',
        'updatedFrom',
        'created_at',
        'updated_at',
    ];
}
