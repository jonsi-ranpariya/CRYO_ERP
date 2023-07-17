<?php

namespace App\Actions\Purchase;

use App\Models\Master\ItemMaster;
use App\Models\Purchase\PurchaseCosting;
use App\Models\Purchase\PurchaseCostingItems;
use Illuminate\Http\Request;
use Lorisleiva\Actions\Concerns\AsAction;

class PurchaseCostingAddDataWithItemAction
{
    use AsAction;

    private PurchaseCosting $purchaseCosting;
    private ItemMaster $itemMaster;
    private PurchaseCostingItems $purchaseCostingItem;

    /**
     * PurchaseCostingAddDataWithItemAction constructor.
     * @param PurchaseCosting $purchaseCosting
     * @param ItemMaster $itemMaster
     * @param PurchaseCostingItems $purchaseCostingItem
     */
    public function __construct(PurchaseCosting $purchaseCosting,
                                ItemMaster $itemMaster,
                                PurchaseCostingItems $purchaseCostingItem)
    {

        $this->purchaseCosting = $purchaseCosting;
        $this->itemMaster = $itemMaster;
        $this->purchaseCostingItem = $purchaseCostingItem;
    }

    public function handle(Request $request)
    {
        $dataInsert = $request->all();
        $response = $this->purchaseCosting->saveData($dataInsert);

        if (!empty($dataInsert['pcItemCode'])) {
            $itemDetail = $this->itemMaster->getDataFromId($dataInsert['pcItemCode'], false, ['itemDetails', 'uom']);
            $itemDataInsert['purchaseCostingId'] = $response->_id;
            $itemDataInsert['itemCode'] = $dataInsert['pcItemCode'];
            $itemDataInsert['itemDescription'] = $dataInsert['pcItemDescription'];
            $itemDataInsert['itemAddDescription'] = $itemDetail->itemDetails['description'] ?? null;
            $itemDataInsert['itemDetailDescription'] = $itemDetail->itemDetails['detailDescription'] ?? null;
            $itemDataInsert['itemDrawingNo'] = $dataInsert['pcDrawingNo'];
            $itemDataInsert['itemRevision'] = $dataInsert['pcDrawingRev'];
            $itemDataInsert['itemUom'] = $itemDetail->uom;
            $itemDataInsert['itemRate'] = 0;
            $this->purchaseCostingItem->saveData($itemDataInsert);
        }

        return $response;
    }
}
