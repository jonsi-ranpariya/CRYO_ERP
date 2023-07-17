<?php

namespace App\Actions\ItemMaster;

use App\Models\Master\ItemMaster;
use Illuminate\Http\Request;
use Lorisleiva\Actions\Concerns\AsAction;

class ItemMasterFilterAction
{
    use AsAction;

    private ItemMaster $itemMaster;

    public function __construct(ItemMaster $itemMaster)
    {
        $this->itemMaster = $itemMaster;
    }

    public function handle(Request $request)
    {
        $itemCode = $request->itemCode;
        $itemDescription = $request->itemDescription;
        $detailsDescription = $request->detailDescription;
        $drawingNumber = $request->drawingNumber;
        $forJobCard = $request->forJobCard;

        $itemMaster = $this->itemMaster->with('uomItem');

        if (!empty($itemCode)) {
            $itemMaster->where('itemCode', 'LIKE', "%{$itemCode}%");
        }

        if (!empty($itemDescription)) {
            $itemMaster->where('itemDescription', 'LIKE', "%{$itemDescription}%");
        }

        if (!empty($detailsDescription)) {
            $itemMaster->where('itemDetails.detailDescription', 'LIKE', "%{$detailsDescription}%");
        }

        if (!empty($drawingNumber)) {
            $itemMaster->where('itemDetails.drawingNumber', 'LIKE', "%{$drawingNumber}%");
        }
        if($forJobCard === true){
            $itemMaster->where('materialProcessType', '!=', 2);
            $itemMaster->where('materialProcessType', '!=', null);
        }
        if (empty($itemCode) && empty($itemDescription) && empty($detailsDescription) && empty($drawingNumber)) {
            $response = [];
        } else {
            $response = $itemMaster->get();
        }

        return $response;
    }
}
