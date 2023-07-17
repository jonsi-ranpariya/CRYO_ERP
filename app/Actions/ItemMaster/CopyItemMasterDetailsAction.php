<?php

namespace App\Actions\ItemMaster;

use App\Models\Master\ItemMaster;
use Illuminate\Http\Request;
use Lorisleiva\Actions\Concerns\AsAction;

class CopyItemMasterDetailsAction
{
    use AsAction;
    private ItemMaster $itemMaster;

    public function __construct(ItemMaster $itemMaster)
    {
        $this->itemMaster = $itemMaster;
    }

    public function handle(Request $request)
    {
        $id = $request->id;

        $itemData = $this->itemMaster->getDataFromId($id);
        $dataInsert['make'] = $itemData->make;
        $dataInsert['itemCategory'] = $itemData->itemCategory;
        $dataInsert['itemGroup'] = $itemData->itemGroup;
        $dataInsert['itemCode'] = null;
        $dataInsert['itemDescription'] = $itemData->itemDescription;
        $dataInsert['uom'] = $itemData->uom;
        $dataInsert['cFactor'] = $itemData->cFactor;
        $dataInsert['convQty'] = $itemData->convQty;
        $dataInsert['convUom'] = $itemData->convUom;
        $dataInsert['batchWiseStock'] = $itemData->batchWiseStock;
        $dataInsert['itemType'] = $itemData->itemType;
        $dataInsert['materialProcessType'] = $itemData->materialProcessType;
        $dataInsert['considerInAccount'] = $itemData->considerInAccount;
        $dataInsert['status'] = $itemData->status;
        $dataInsert['reason'] = $itemData->reason;
        $dataInsert['date'] = $itemData->date;
        $dataInsert['planning'] = $itemData->planning;
        $dataInsert['stockAllocationAtWo'] = $itemData->stockAllocationAtWo;
        $dataInsert['serialNoWiseStock'] = $itemData->serialNoWiseStock;
        $dataInsert['itemDetails'] = $itemData->itemDetails;
        $dataInsert['hsnSacDetails'] = $itemData->hsnSacDetails;
        $dataInsert['purchaseData'] = $itemData->purchaseData;
        $dataInsert['generalData'] = $itemData->generalData;
        $dataInsert['companyId'] = $itemData->companyId;
        $dataInsert['addedFrom'] = $itemData->addedFrom;

        return $this->itemMaster->saveData($dataInsert);
    }
}
