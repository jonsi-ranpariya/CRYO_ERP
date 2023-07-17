<?php

namespace App\Observers\Bom;

use App\Models\Bom\BillOfMaterial;
use App\Models\Bom\BomVersionItem;

class BomVersionItemObserver
{
    /**
     * Handle the BomVersionItem "created" event.
     *
     * @param BomVersionItem $bomVersionItem
     * @return void
     */
    public function created(BomVersionItem $bomVersionItem): void
    {
        //
    }

    /**
     * Handle the BomVersionItem "updated" event.
     *
     * @param BomVersionItem $bomVersionItem
     * @return void
     */
    public function updated(BomVersionItem $bomVersionItem): void
    {
        $bomId = $bomVersionItem->bomId;
        $bom = BillOfMaterial::find($bomId, ['itemCode']);
        $bom->setAppends([]);

        $parentIds = BomVersionItem::query()
            ->where('itemCode', $bom->itemCode)
            ->pluck('_id')
            ->toArray();

        if (count($parentIds) > 0) {
            BomVersionItem::query()
                ->whereIn('versionItemId', $parentIds)
                ->where('itemCode', $bomVersionItem->itemCode)
                ->update([
                    'itemBomQty' => $bomVersionItem->itemBomQty,
                    'itemBomQtyConv' => $bomVersionItem->itemBomQtyConv,
                    'itemConvFactor' => $bomVersionItem->itemConvFactor,
                    'itemConvQty' => $bomVersionItem->itemConvQty,
                ]);
        }
    }

    /**
     * Handle the BomVersionItem "deleted" event.
     *
     * @param BomVersionItem $bomVersionItem
     * @return void
     */
    public function deleted(BomVersionItem $bomVersionItem): void
    {
        //
    }

    /**
     * Handle the BomVersionItem "restored" event.
     *
     * @param BomVersionItem $bomVersionItem
     * @return void
     */
    public function restored(BomVersionItem $bomVersionItem): void
    {
        //
    }

    /**
     * Handle the BomVersionItem "force deleted" event.
     *
     * @param BomVersionItem $bomVersionItem
     * @return void
     */
    public function forceDeleted(BomVersionItem $bomVersionItem): void
    {
        //
    }
}
