<?php

namespace App\Observers\Purchase;

use App\Models\Inventory\GoodsReceiptNoteItem;
use App\Models\Purchase\PurchaseOrderItem;

class PurchaseOrderItemObserver
{
    /**
     * Handle the PurchaseOrderItem "updating" event.
     *
     * @param PurchaseOrderItem $purchaseOrderItem
     * @return void
     */
    public function updating(PurchaseOrderItem $purchaseOrderItem): void
    {
        $upSum = GoodsReceiptNoteItem::query()->where([
            'poItemId' => $purchaseOrderItem->_id,
            'purchaseOrderId' => $purchaseOrderItem->purchaseOrderId
        ])->sum('poQuantityUp');
        $umSum = GoodsReceiptNoteItem::query()->where([
            'poItemId' => $purchaseOrderItem->_id,
            'purchaseOrderId' => $purchaseOrderItem->purchaseOrderId
        ])->sum('poQuantityUm');

        $purchaseOrderItem->pendingQtyUm = (int)$purchaseOrderItem->pendingQtyUm - $umSum;
        $purchaseOrderItem->pendingQtyUp = (int)$purchaseOrderItem->pendingQtyUp - $upSum;

        if ($purchaseOrderItem->pendingQtyUp == 0 and $purchaseOrderItem->pendingQtyUm == 0) {
            $purchaseOrderItem->itemStatus = 3;
        } else {
            $purchaseOrderItem->itemStatus = 1;
        }
    }
}
