<?php

namespace App\Models\SalesCrm;

use App\Models\BaseModel;

class SalesOrderPaymentSchedule extends BaseModel
{
    protected $collection = 'sales_order_payment_schedule';
    protected $fillable = [
        'addedFrom',
        'updatedFrom',
        'created_at',
        'updated_at',
        'salesOrderId',
        'payment',
        'dueDate',
        'days',
        'expDate',
        'amount',
        'pendingAmount',
        'status',
    ];
}
