<?php

namespace App\Observers\Bom;

use App\Models\Bom\BillOfMaterial;
use App\Models\Bom\BillOfMaterialVersion;
use App\Models\Bom\BomVersionItem;
use Illuminate\Support\Facades\Log;

class BillOfMaterialVersionObserver
{
    /**
     * Handle the BillOfMaterialVersion "created" event.
     *
     * @param BillOfMaterialVersion $billOfMaterialVersion
     * @return void
     */
    public function created(BillOfMaterialVersion $billOfMaterialVersion): void
    {
        $bomId = $billOfMaterialVersion->bomId;
        $bomNumber = $billOfMaterialVersion->bomNumber;
        $bom = BillOfMaterial::find($bomId, ['itemCode']);
        $bom->setAppends([]);
        $itemCode = $bom->itemCode;

        BomVersionItem::query()
            ->where('itemCode', $itemCode)
            ->update(['itemAssemblyBomNumber' => $bomNumber]);

        if ($billOfMaterialVersion->bomDefault == '1') {
            BillOfMaterialVersion::query()
                ->where('_id', '!=', $billOfMaterialVersion->_id)
                ->where('bomId', $bomId)
                ->update(['bomDefault' => null]);
        }
    }

    /**
     * Handle the BillOfMaterialVersion "updated" event.
     *
     * @param BillOfMaterialVersion $billOfMaterialVersion
     * @return void
     */
    public function updated(BillOfMaterialVersion $billOfMaterialVersion): void
    {
        $bomId = $billOfMaterialVersion->bomId;

        if ($billOfMaterialVersion->bomDefault == '1') {
            BillOfMaterialVersion::query()
                ->where('_id', '!=', $billOfMaterialVersion->_id)
                ->where('bomId', $bomId)
                ->update(['bomDefault' => null]);
        }
    }

    /**
     * Handle the BillOfMaterialVersion "deleted" event.
     *
     * @param BillOfMaterialVersion $billOfMaterialVersion
     * @return void
     */
    public function deleted(BillOfMaterialVersion $billOfMaterialVersion): void
    {
        //
    }

    /**
     * Handle the BillOfMaterialVersion "restored" event.
     *
     * @param BillOfMaterialVersion $billOfMaterialVersion
     * @return void
     */
    public function restored(BillOfMaterialVersion $billOfMaterialVersion): void
    {
        //
    }

    /**
     * Handle the BillOfMaterialVersion "force deleted" event.
     *
     * @param BillOfMaterialVersion $billOfMaterialVersion
     * @return void
     */
    public function forceDeleted(BillOfMaterialVersion $billOfMaterialVersion): void
    {
        //
    }
}
