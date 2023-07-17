<?php

namespace App\Actions\Purchase;

use App\Models\Purchase\PurchaseOrderItem;
use App\Models\Purchase\PurchaseQuotationItems;
use Lorisleiva\Actions\Concerns\AsAction;

class PurchaseOrderAddMultipleItemAction
{
    use AsAction;

    private PurchaseQuotationItems $purchaseQuotationItems;
    private PurchaseOrderItem $purchaseOrderItem;

    /**
     * PurchaseOrderAddMultipleItemAction constructor.
     * @param PurchaseQuotationItems $purchaseQuotationItems
     * @param PurchaseOrderItem $purchaseOrderItem
     */
    public function __construct(PurchaseQuotationItems $purchaseQuotationItems, PurchaseOrderItem $purchaseOrderItem)
    {
        $this->purchaseQuotationItems = $purchaseQuotationItems;
        $this->purchaseOrderItem = $purchaseOrderItem;
    }

    /**
     * @param array $ids
     * @param string $purchaseOrderId
     */
    public function handle(array $ids, string $purchaseOrderId)
    {
        $items = $this->purchaseQuotationItems->whereInData('_id', $ids);

        foreach ($items as $key => $item) {
            $data['purchaseOrderId'] = $purchaseOrderId;
            $data['itemCode'] = $item->itemCode;
            $data['itemDescription'] = $item->itemDescription;
            $data['itemDescVendor'] = null;
            $data['itemAddDescription'] = $item->itemAddDescription;
            $data['itemDetailDescription'] = $item->itemDetailDescription;
            $data['itemUom'] = $item->itemUom;
            $data['itemup'] = null;
            $data['itemFactor'] = null;
            $data['itemQty'] = $item->itemQuantity;
            $data['itemQuantityUm'] = 0;
            $data['itemQuantityUp'] = 0;
            $data['itemQuntityNos'] = 0;
            $data['itemRate'] = $item->itemRate;
            $data['itemDiscount'] = $item->itemDiscPercent;
            $data['itemDiscountValue'] = $item->itemDiscValue;
            $data['itemAmount'] = $item->itemAmount;
            $data['itemNetAmount'] = $item->itemNetAmount;
            $data['itemSize'] = 0;
            $data['itemIndentNo'] = null;
            $data['itemIndenter'] = null;
            $data['itemRemark'] = $item->itemNote;
            $data['itemJobNumber'] = null;
            $data['itemMake'] = null;
            $data['itemStore'] = null;
            $data['itemDrowingNo'] = $item->itemDrawingNumber;
            $data['itemRev'] = $item->itemDrawingRevision;
            $data['itemStatus'] = $item->itemStatus;
            $data['itemDeliveryDate'] = null;
            $data['itemSoNumber'] = null;
            $data['itemWoNumber'] = null;
            $data['itemForcastNo'] = null;

            $this->purchaseOrderItem->saveData($data);
        }
    }
}
