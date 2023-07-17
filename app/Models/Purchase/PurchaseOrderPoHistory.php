<?php

namespace App\Models\Purchase;

use App\Models\BaseModel;

class PurchaseOrderPoHistory extends BaseModel
{
//    protected $connection = 'mongodb';

    protected $collection = 'purchase_order_po_history';
    protected $fillable = [
        'purchaseOrderId',
        'poDate',
        'poHistory',
    ];
}
