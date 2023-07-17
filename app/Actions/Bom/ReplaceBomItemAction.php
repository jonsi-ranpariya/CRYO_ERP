<?php

namespace App\Actions\Bom;

use App\Models\Bom\BomVersionItem;
use App\Models\Master\ItemMaster;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Lorisleiva\Actions\Concerns\AsAction;

class ReplaceBomItemAction
{
    use AsAction;

    public function handle(Request $request): JsonResponse
    {
        $oldItems = collect($request->oldItems);
        $newItem = $request->newItem;

        $itemMaster = ItemMaster::getFirstDataWithRelation(
            ['_id' => $newItem],
            ['uomItem:_id,uom']
        );

        $oldItems->each(function ($oldItem) use ($itemMaster) {
            $item = BomVersionItem::getFirstData($oldItem);
            $item->itemCode = $itemMaster->_id ?? null;
            $item->itemDescription = $itemMaster->itemDescription ?? null;
            $item->itemAddDescription = $itemMaster['itemDetails']['description'] ?? null;
            $item->itemDrawingNumber = $itemMaster['itemDetails']['drawingNumber'] ?? null;
            $item->itemMaterialSpecification = $itemMaster['itemDetails']['materialSpecification'] ?? null;
            $item->itemConvFactor = $itemMaster->cFactor ?? null;
            $item->itemConvQty = $itemMaster->convQty ?? null;
            $item->itemUom = $itemMaster->uomItem->uom ?? null;
            if ($itemMaster->materialProcessType == 2) {
                $item->itemType = 'I';
            } else {
                $item->itemType = 'A';
            }
            $item->itemMaterialProcessType = $itemMaster->materialProcessType ?? null;
            $item->itemNote = $itemMaster['itemDetails']['remarkNote'] ?? null;
            $item->itemDetailDescription = $itemMaster['itemDetails']['detailDescription'] ?? null;
            $item->itemDrawingRevision = $itemMaster['itemDetails']['revision'] ?? null;
            $item->itemMake = $itemMaster->make ?? null;
            $item->update();
        });

        $res['status'] = 200;
        $res['message'] = 'Item Details Replaced';
        return jsonData($res);
    }
}
