<?php

namespace App\Services\sales;

use App\Http\Requests\SalesCrm\SalesOrderItemUpdateRequest;
use App\Models\Despatch\NewChallanInvoiceItems;
use App\Models\SalesCrm\SalesOrderItems;

class SalesOrderItemService
{
    public function updateSalesOrderItem($id, SalesOrderItemUpdateRequest $request)
    {
        $updateData = $request->all();
        $salesOrderId = $updateData['salesOrderId'];

        $totalItemQty = NewChallanInvoiceItems::query()
            ->where('salesOrderId', $salesOrderId)
            ->where('salesOrderItemId', $id)
            ->sum('itemQuantity');
        $updateData['itemPendingQuantity'] = (float)$updateData['itemQuantity'] - (float)$totalItemQty;

        if ($updateData['itemPendingQuantity'] == 0) {
            $updateData['itemStatus'] = 'Completed';
        } else {
            $updateData['itemStatus'] = 'Pending';
        }

        return SalesOrderItems::updateData($id, $updateData);
    }
}
