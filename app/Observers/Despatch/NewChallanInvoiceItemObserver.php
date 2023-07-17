<?php

namespace App\Observers\Despatch;

use App\Models\Despatch\NewChallanInvoiceItems;
use App\Models\SalesCrm\SalesOrderItems;

class NewChallanInvoiceItemObserver
{
    public function created(NewChallanInvoiceItems $newChallanInvoiceItems): void
    {
        $salesOrderItemId = $newChallanInvoiceItems->salesOrderItemId;
        $salesOrderItem = SalesOrderItems::find($salesOrderItemId);
        $totalUsedQty = NewChallanInvoiceItems::query()
            ->where([
                'salesOrderItemId' => $salesOrderItemId,
                'salesOrderId' => $salesOrderItem->salesOrderId
            ])->sum('itemQuantity');
        $minusQty = $totalUsedQty == 0 ? $newChallanInvoiceItems->itemQuantity : $totalUsedQty;
        $salesOrderItem->itemPendingQuantity = $salesOrderItem->itemQuantity - $minusQty;
        if ($salesOrderItem->itemPendingQuantity == 0) {
            $salesOrderItem->itemStatus = 'Completed';
        } else {
            $salesOrderItem->itemStatus = 'Pending';
        }
        $salesOrderItem->update();
    }

    /**
     * Handle the NewChallanInvoiceItems "updating" event.
     *
     * @param NewChallanInvoiceItems $newChallanInvoiceItems
     * @return void
     */
    public function updating(NewChallanInvoiceItems $newChallanInvoiceItems): void
    {
        if (is_object($newChallanInvoiceItems)) {
            $newChallanInvoiceItems->itemQuantity = (float)$newChallanInvoiceItems->itemQuantity;
        }
        if (is_array($newChallanInvoiceItems)) {
            $newChallanInvoiceItems['itemQuantity'] = (float)$newChallanInvoiceItems['itemQuantity'];
        }
    }

    public function updated(NewChallanInvoiceItems $newChallanInvoiceItems): void
    {
        $salesOrderItemId = $newChallanInvoiceItems->salesOrderItemId;
        $salesOrderItem = SalesOrderItems::find($salesOrderItemId);
        $totalUsedQty = NewChallanInvoiceItems::query()
            ->where([
                'salesOrderItemId' => $salesOrderItemId,
                'salesOrderId' => $salesOrderItem->salesOrderId
            ])->sum('itemQuantity');
        $salesOrderItem->itemPendingQuantity = $salesOrderItem->itemQuantity - $totalUsedQty;
        if ($salesOrderItem->itemPendingQuantity == 0) {
            $salesOrderItem->itemStatus = 'Completed';
        } else {
            $salesOrderItem->itemStatus = 'Pending';
        }
        $salesOrderItem->update();
    }

    public function deleted(NewChallanInvoiceItems $newChallanInvoiceItems): void
    {
        $salesOrderItemId = $newChallanInvoiceItems->salesOrderItemId;
        $salesOrderItem = SalesOrderItems::find($salesOrderItemId);
        $salesOrderItem->itemPendingQuantity = $salesOrderItem->itemPendingQuantity + $newChallanInvoiceItems->itemQuantity;
        if ($salesOrderItem->itemPendingQuantity == 0) {
            $salesOrderItem->itemStatus = 'Completed';
        } else {
            $salesOrderItem->itemStatus = 'Pending';
        }
        $salesOrderItem->update();
    }
}
