<?php

namespace App\Observers\Inventory;

use App\Models\Inventory\GoodsReceiptNoteItem;
use App\Models\Purchase\PurchaseOrderItem;

class GoodReceiptNoteItemObserver
{
    /**
     * Handle the GoodReceiptNoteItem "created" event.
     *
     * @param  GoodsReceiptNoteItem  $goodReceiptNoteItem
     * @return void
     */
    public function created(GoodsReceiptNoteItem $goodReceiptNoteItem): void
    {
        $poItem = PurchaseOrderItem::query()->find($goodReceiptNoteItem->poItemId);
        $poItem->pendingQtyUm = (int)$poItem->pendingQtyUm - (int)$goodReceiptNoteItem->poQuantityUm;
        $poItem->pendingQtyUp = (int)$poItem->pendingQtyUp - (int)$goodReceiptNoteItem->poQuantityUp;

        if ($poItem->pendingQtyUm == 0 && $poItem->pendingQtyUp == 0) {
            $poItem->itemStatus = 3;
        }

        $poItem->update();
    }

    /**
     * Handle the GoodReceiptNoteItem "updated" event.
     *
     * @param  GoodsReceiptNoteItem  $goodReceiptNoteItem
     * @return void
     */
    public function updated(GoodsReceiptNoteItem $goodReceiptNoteItem): void
    {
        $poItem = PurchaseOrderItem::query()->find($goodReceiptNoteItem->poItemId);
        $poItem->pendingQtyUm = (int)$poItem->pendingQtyUm - (int)$goodReceiptNoteItem->poQuantityUm;
        $poItem->pendingQtyUp = (int)$poItem->pendingQtyUp - (int)$goodReceiptNoteItem->poQuantityUp;

        if ($poItem->pendingQtyUm == 0 && $poItem->pendingQtyUp == 0) {
            $poItem->itemStatus = 3;
        }

        $poItem->update();
    }

    /**
     * Handle the GoodReceiptNoteItem "deleted" event.
     *
     * @param  GoodsReceiptNoteItem  $goodReceiptNoteItem
     * @return void
     */
    public function deleted(GoodsReceiptNoteItem $goodReceiptNoteItem): void
    {
        $poItem = PurchaseOrderItem::query()->find($goodReceiptNoteItem->poItemId);
        $poItem->pendingQtyUm = (int)$poItem->pendingQtyUm + (int)$goodReceiptNoteItem->poQuantityUm;
        $poItem->pendingQtyUp = (int)$poItem->pendingQtyUp + (int)$goodReceiptNoteItem->poQuantityUp;

        if ($poItem->pendingQtyUm != 0 && $poItem->pendingQtyUp != 0) {
            $poItem->itemStatus = 1;
        }

        $poItem->update();
    }

    /**
     * Handle the GoodReceiptNoteItem "restored" event.
     *
     * @param  GoodsReceiptNoteItem  $goodReceiptNoteItem
     * @return void
     */
    public function restored(GoodsReceiptNoteItem $goodReceiptNoteItem): void
    {
        //
    }

    /**
     * Handle the GoodReceiptNoteItem "force deleted" event.
     *
     * @param  GoodsReceiptNoteItem  $goodReceiptNoteItem
     * @return void
     */
    public function forceDeleted(GoodsReceiptNoteItem $goodReceiptNoteItem): void
    {
        //
    }
}
