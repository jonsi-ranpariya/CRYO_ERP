<?php

namespace App\Actions\ItemMaster;

use App\Models\Master\ItemMaster;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Lorisleiva\Actions\Concerns\AsAction;

class ItemMasterListFilterAction
{
    use AsAction;

    public function __construct(protected ItemMaster $itemMaster)
    {
    }

    public function handle(Request $request): JsonResponse
    {
        $itemCategory = $request->itemCategory ?? null;
        $itemGroup = $request->itemGroup ?? null;
        $itemType = $request->itemType ?? null;
        $itemMainGroup = $request->itemMainGroup ?? null;
        $itemSubGroup = $request->itemSubGroup ?? null;
        $itemCode = $request->itemCode ?? null;
        $itemDescription = $request->itemDescription ?? null;
        $itemDetailDescription = $request->itemDetailDescription ?? null;
        $itemDrawingNumber = $request->itemDrawingNumber ?? null;
        $iteMaster = $this->itemMaster->query();

        if ($itemCategory) {
            $iteMaster->where('itemCategory', $itemCategory);
        }
        if ($itemGroup) {
            $iteMaster->where('itemGroup', $itemGroup);
        }
        if ($itemType) {
            $iteMaster->where('itemType', $itemType);
        }
        if ($itemMainGroup) {
            $iteMaster->where('itemDetails.mainGroup', $itemMainGroup);
        }
        if ($itemSubGroup) {
            $iteMaster->where('itemDetails.subGroup', $itemSubGroup);
        }
        if ($itemCode) {
            $iteMaster->where('itemCode', $itemCode);
        }
        if ($itemDescription) {
            $iteMaster->where('itemDescription', $itemDescription);
        }
        if ($itemDetailDescription) {
            $iteMaster->where('itemDetails.detailDescription', $itemDetailDescription);
        }
        if ($itemDrawingNumber) {
            $iteMaster->where('itemDetails.drawingNumber', $itemDrawingNumber);
        }

        return jsonData(['data' => $iteMaster->get()]);
    }
}
