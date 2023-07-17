<?php

namespace App\Models\SalesCrm;

use App\Models\BaseModel;
use App\QueryBuilders\SalesOrderTermConditionQueryBuilder;

/**
 * @method printTermOnly()
 * @method generalOnly()
 * @method generalWorkOrderOnly()
 * @method workOrderOnly()
 * @method invoiceOnly()
 * @method invoiceWorkOrderOnly()
 */
class SalesOrderTermCondition extends BaseModel
{
    protected $collection = 'sales_order_term_condition';
    protected $fillable = [
        'salesOrderId',
        'termConditionId',
        'termGroupName',
        'termDetail',
        'termConditionFor',
        'termConditionForName',
        'isPrint',
        'companyId',
        'addedFrom',
        'updatedFrom',
    ];

    public function newEloquentBuilder($query): SalesOrderTermConditionQueryBuilder
    {
        return new SalesOrderTermConditionQueryBuilder($query);
    }
}
