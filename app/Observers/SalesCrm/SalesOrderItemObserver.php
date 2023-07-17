<?php

namespace App\Observers\SalesCrm;

use App\Models\SalesCrm\SalesOrder;
use App\Models\SalesCrm\SalesOrderItems;

class SalesOrderItemObserver
{
    public function updated(SalesOrderItems $salesOrderItem): void
    {
        $salesOrderId = $salesOrderItem->salesOrderId;
        if ($salesOrderId) {
            $salesOrder = SalesOrder::find($salesOrderId);
            $salesOrderItems = SalesOrderItems::query()
                ->where(['salesOrderId' => $salesOrderId])
                ->pluck('itemStatus')
                ->toArray();
            if (in_array('Pending', $salesOrderItems)) {
                $salesOrder->salesOrderStatus = 'Pending';
            } else {
                $salesOrder->salesOrderStatus = 'Completed';
            }
            $salesOrder->update();
        }
    }
}
