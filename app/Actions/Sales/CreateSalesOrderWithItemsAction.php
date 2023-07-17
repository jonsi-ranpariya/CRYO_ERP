<?php

namespace App\Actions\Sales;

use App\Models\SalesCrm\SalesOrder;
use App\Models\SalesCrm\SalesOrderItems;
use App\Models\SalesCrm\SalesQuotationItems;
use Illuminate\Http\Request;
use Lorisleiva\Actions\Concerns\AsAction;

class CreateSalesOrderWithItemsAction
{
    use AsAction;

    public function handle(Request $request): ?object
    {
        $dataInsert = $request->all();
        $qtnItemIds = $dataInsert['qtnItemIds'];
        $response = SalesOrder::saveData($dataInsert);
        if ($response)
            $this->createSalesOrderItem(
                salesOrder: $response,
                qtnItemIds: $qtnItemIds
            );
        return $response;
    }

    private function createSalesOrderItem(SalesOrder $salesOrder, array $qtnItemIds): void
    {
        $items = SalesQuotationItems::query()->whereIn('_id', $qtnItemIds)->get();
        $items->each(callback: function (SalesQuotationItems $item) use ($salesOrder) {
            $dataInsert = [
                'salesOrderId' => $salesOrder->_id,
                'salesOrderNo' => $salesOrder->salesOrderNo,
                'itemId' => $item->itemCode['value'],
                'itemCode' => $item->itemDetails()->first(['_id', 'itemCode'])->itemCode ?? null,
                'itemName' => $item->itemDescription,
                'itemCustomDescription' => $item->itemDescCust,
                'itemAddonDescription' => $item->addDescription,
                'itemDetailDescription' => $item->detailDescription,
                'itemMake' => $item->itemDetails()->first(['_id', 'make'])->make ?? null,
                'itemDrawingNo' => $item->drawingNumber,
                'itemDrawingRev' => $item->rev,
                'itemProject' => $salesOrder->salesOrderProject,
                'itemInternalNote' => null,
                'itemSalesType' => null,
                'itemUom' => $item->uom,
                'itemMsnNumber' => null,
                'itemCustPartNo' => $item->custPartNo,
                'itemNote' => $item->itemNote,
                'itemQuantity' => $item->requireQty,
                'itemPendingQuantity' => $item->requireQty,
                'itemRate' => $item->rate,
                'itemDiscount' => $item->discPercent,
                'itemDiscountVal' => $item->discValue,
                'itemNetAmount' => $item->netAmount,
                'itemAmount' => $item->amount,
                'itemStatus' => 'Pending',
                'itemType' => null,
                'itemQtnRefNo' => $salesOrder->qtnRefNo,
                'itemQtnSrNo' => null,
                'itemDocuments' => null,
                'itemStockStatus' => null,
                'itemHolUnhold' => null,
                'itemHsnSacNumber' => $item->itemDetails()->first(['_id', 'hsnSacDetails'])?->hsnSacDetails['hsnSacNo'] ?? null,
                'itemHsnSacId' => $item->itemDetails()->first(['_id', 'hsnSacDetails'])?->hsnSacDetails['hsnSacDescription']['value'] ?? null,
                'itemConvUom' => null,
                'itemCFactor' => null,
                'itemConvQty' => null,
                'itemCgstPercentage' => null,
                'itemSgstPercentage' => null,
                'itemIgstPercentage' => null,
                'itemCgstAmount' => null,
                'itemSgstAmount' => null,
                'itemIgstAmount' => null
            ];
            SalesOrderItems::saveData($dataInsert);
        });
    }
}
