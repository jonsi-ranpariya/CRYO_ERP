<?php

namespace App\Actions\Purchase;

use App\Models\MRP\MrpIndent;
use App\Models\Purchase\PurchaseOrderItem;
use App\Models\Purchase\PurchaseQuotationItems;
use App\Models\SalesCrm\SalesOrderItems;
use App\Services\Mrp\IndentService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Lorisleiva\Actions\Concerns\AsAction;

class PurchaseOrderModalItemsAction
{
    use AsAction;

    /**
     * PurchaseOrderModalItemsAction constructor.
     * @param MrpIndent $indentItem
     * @param SalesOrderItems $salesOrderItems
     * @param PurchaseQuotationItems $purchaseQuotationItem
     * @param PurchaseOrderItem $purchaseOrderItem
     */
    public function __construct(
        protected MrpIndent              $indentItem,
        protected SalesOrderItems        $salesOrderItems,
        protected PurchaseQuotationItems $purchaseQuotationItem,
        protected PurchaseOrderItem      $purchaseOrderItem
    )
    {
    }

    public function handle(Request $request)
    {
        $type = $request->type;
        $ids = $request->ids;
        $purchaseOrderId = $request->purchaseOrderId;
        $response = false;

        if ($type === '1' && !empty($ids)) {
            $items = $this->indentItem->whereInData('_id', $ids);
            foreach ($items as $key => $item) {
                $dataInsert['itemId'] = $item->itemCode ?? null;
                $dataInsert['itemCode'] = $item->itemCode ?? null;
                $dataInsert['itemDescription'] = $item->itemDescription ?? null;
                $dataInsert['itemDescVendor'] = null;
                $dataInsert['itemAddDescription'] = $item->addDescription ?? null;
                $dataInsert['itemDetailDescription'] = $item->detailDescription ?? null;
                $dataInsert['itemUom'] = $item->uom ?? null;
                $dataInsert['itemup'] = $item->uom ?? null;
                $dataInsert['itemFactor'] = $item->cFactor ?? null;
                $dataInsert['itemQty'] = $item->conveQty ?? null;
                $dataInsert['itemQuantityUm'] = $item->reqQtyUm ?? null;
                $dataInsert['itemQuantityUp'] = $item->reqQtyUp ?? null;
                $dataInsert['itemRate'] = 0;
                $dataInsert['itemDiscount'] = 0;
                $dataInsert['itemDiscountValue'] = 0;
                $dataInsert['itemAmount'] = 0;
                $dataInsert['itemNetAmount'] = 0;
                $dataInsert['itemSize'] = $item->size ?? null;
                $dataInsert['itemIndentNo'] = $item->indentNo ?? null;
                $dataInsert['itemIndentDate'] = $item->indentDate ?? null;
                $dataInsert['itemIndenter'] = $item->loginDetails['createdBy'] ?? null;
                $dataInsert['itemRemark'] = $item->remark ?? null;
                $dataInsert['itemJobNumber'] = null;
                $dataInsert['itemMake'] = $item->itemMake ?? null;
                $dataInsert['itemStore'] = $item->store[0] ?? null;
                $dataInsert['itemDrowingNo'] = $item->drawingNumber ?? null;
                $dataInsert['itemRev'] = $item->itemRev ?? 0;
                $dataInsert['itemStatus'] = 1;
                $dataInsert['itemDeliveryDate'] = null;
                $dataInsert['itemSoNumber'] = $item->soId ?? null;
                $dataInsert['itemWoNumber'] = $item->woId ?? null;
                $dataInsert['itemForcastNo'] = null;
                $dataInsert['itemHsnNumber'] = null;
                $dataInsert['purchaseOrderId'] = $purchaseOrderId;
                $response = $this->purchaseOrderItem->saveData($dataInsert) ?? null;
            }
            return $response;
        }

        if ($type === '2' && !empty($ids)) {

            $items = $this->salesOrderItems->whereInData('_id', $ids);

            foreach ($items as $item) {
                $intendItem = (new IndentService($type, $item))->execute();
                if ($intendItem == null) {
                    return false;
                }

                $dataInsert['itemId'] = $item->itemId ?? null;
                $dataInsert['itemCode'] = $item->itemId ?? null;
                $dataInsert['itemDescription'] = $item->itemName ?? null;
                $dataInsert['itemDescVendor'] = null;
                $dataInsert['itemAddDescription'] = $item->itemAddonDescription ?? null;
                $dataInsert['itemDetailDescription'] = $item->itemDetailDescription ?? null;
                $dataInsert['itemUom'] = $item->itemUom ?? null;
                $dataInsert['itemup'] = $item->itemUom ?? null;
                $dataInsert['itemFactor'] = null;
                $dataInsert['itemQty'] = $item->itemQuantity ?? null;
                $dataInsert['itemQuantityUm'] = 0;
                $dataInsert['itemQuantityUp'] = 0;
                $dataInsert['itemQuntityNos'] = 0;
                $dataInsert['itemRate'] = $item->itemRate ?? null;
                $dataInsert['itemDiscount'] = $item->itemDiscount ?? null;
                $dataInsert['itemDiscountValue'] = $item->itemDiscountVal ?? null;
                $dataInsert['itemAmount'] = $item->itemAmount ?? null;
                $dataInsert['itemNetAmount'] = $item->itemNetAmount ?? null;
                $dataInsert['itemSize'] = null;
                $dataInsert['itemIndentNo'] = $intendItem->indentNo;
                $dataInsert['itemIndentDate'] = Carbon::parse($intendItem->created_at)->format('d/m/Y');
                $dataInsert['itemIndenter'] = $intendItem->loginDetails['createdBy'] ?? null;
                $dataInsert['itemRemark'] = $item->itemNote ?? null;
                $dataInsert['itemJobNumber'] = null;
                $dataInsert['itemMake'] = null;
                $dataInsert['itemStore'] = null;
                $dataInsert['itemDrowingNo'] = $item->itemDrawingNo ?? null;
                $dataInsert['itemRev'] = $item->itemDrawingRev ?? null;
                $dataInsert['itemStatus'] = 1;
                $dataInsert['itemDeliveryDate'] = $intendItem->deliveryDate ?? null;
                $dataInsert['itemSoNumber'] = getSalesOrderNumberFromId($intendItem->soId) ?? null;
                $dataInsert['itemWoNumber'] = null;
                $dataInsert['itemForcastNo'] = null;
                $dataInsert['itemHsnNumber'] = $item->itemHsnSacNumber ?? null;
                $dataInsert['purchaseOrderId'] = $purchaseOrderId;
                $response = $this->purchaseOrderItem->saveData($dataInsert) ?? null;
            }
            return $response;
        }

        if ($type === '3' && !empty($ids)) {
            $items = $this->purchaseQuotationItem->whereInData('_id', $ids);
            foreach ($items as $key => $item) {
                $intendItem = (new IndentService($type, $item))->execute();
                if ($intendItem == null) {
                    return false;
                }

                $dataInsert['itemId'] = $item->itemCode ?? null;
                $dataInsert['itemCode'] = $item->itemCode ?? null;
                $dataInsert['itemDescription'] = $item->itemDescription ?? null;
                $dataInsert['itemDescVendor'] = null;
                $dataInsert['itemAddDescription'] = $item->itemAddDescription ?? null;
                $dataInsert['itemDetailDescription'] = $item->itemDetailDescription ?? null;
                $dataInsert['itemUom'] = $item->itemUom ?? null;
                $dataInsert['itemup'] = $item->itemUom ?? null;
                $dataInsert['itemFactor'] = null;
                $dataInsert['itemQty'] = $item->itemQuantity ?? null;
                $dataInsert['itemQuantityUm'] = 0;
                $dataInsert['itemQuantityUp'] = 0;
                $dataInsert['itemQuntityNos'] = 0;
                $dataInsert['itemRate'] = $item->itemRate ?? null;
                $dataInsert['itemDiscount'] = $item->itemDiscPercent ?? null;
                $dataInsert['itemDiscountValue'] = $item->itemDiscValue ?? null;
                $dataInsert['itemAmount'] = $item->itemAmount ?? null;
                $dataInsert['itemNetAmount'] = $item->itemNetAmount ?? null;
                $dataInsert['itemSize'] = null;
                $dataInsert['itemIndentNo'] = $intendItem->indentNo;
                $dataInsert['itemIndentDate'] = Carbon::parse($intendItem->created_at)->format('d/m/Y');
                $dataInsert['itemIndenter'] = $intendItem->loginDetails['createdBy'] ?? null;
                $dataInsert['itemRemark'] = $item->itemNote ?? null;
                $dataInsert['itemJobNumber'] = null;
                $dataInsert['itemMake'] = null;
                $dataInsert['itemStore'] = null;
                $dataInsert['itemDrowingNo'] = $item->itemDrawingNumber ?? null;
                $dataInsert['itemRev'] = $item->itemDrawingRevision ?? null;
                $dataInsert['itemStatus'] = $item->itemStatus ?? null;
                $dataInsert['itemDeliveryDate'] = null;
                $dataInsert['itemSoNumber'] = null;
                $dataInsert['itemWoNumber'] = null;
                $dataInsert['itemForcastNo'] = null;
                $dataInsert['itemHsnNumber'] = $item->itemHsnNumber ?? null;
                $dataInsert['purchaseOrderId'] = $purchaseOrderId;
                $response = $this->purchaseOrderItem->saveData($dataInsert) ?? null;
            }
            return $response;
        }

        return false;
    }
}
