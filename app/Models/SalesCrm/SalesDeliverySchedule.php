<?php

namespace App\Models\SalesCrm;

use App\Models\BaseModel;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Jenssegers\Mongodb\Relations\HasOne;

class SalesDeliverySchedule extends BaseModel
{
    protected $collection = 'sales_order_item_delivery_schedule';

    protected $fillable = [
        'salesOrderItemId',
        'deliveryDate',
        'expectedDate',
        'quantity',
        'salesOrderQty',
        'totalQuantity',
        'addedFrom',
        'updatedFrom',
        'companyId'
    ];

    protected $casts = [
        'quantity' => 'float',
        'salesOrderQty' => 'float',
        'totalQuantity' => 'float'
    ];

    public function salesOrderItem(): HasOne
    {
        return $this->hasOne(SalesOrderItems::class, '_id', 'salesOrderItemId');
    }
}
