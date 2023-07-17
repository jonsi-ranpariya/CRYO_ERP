<?php

namespace App\Services\ProductionPlanning;

use App\Models\Bom\BomVersionItem;
use App\Models\ProductionPlanning\WorkOrder;
use App\Models\ProductionPlanning\WorkOrderItem;

class WorkOrderService
{
    /**
     * @param array $data
     * @return object
     */
    public function saveWorkOrderWithBomItems(
        array $data
    ): object
    {
        $bomVersionId = $data['bomNo'];
        $response = WorkOrder::saveData($data);
        if ($response) {
            if (!empty($bomVersionId)) {
                $items = BomVersionItem::query()
                    ->with('children')
                    ->where('versionId', $bomVersionId)
                    ->whereNull('versionItemId')
                    ->get();
                if ($items->isNotEmpty()) {
                    $this->saveBomVersionItems(
                        items: $items,
                        woId: $response->_id,
                        bomVersionId: $bomVersionId
                    );
                }
            }
        }

        return $response;
    }

    /**
     * @param object $items
     * @param string $woId
     * @param string $bomVersionId
     * @param string|null $versionItemId
     * @return void
     */
    public function saveBomVersionItems(
        object  $items,
        string  $woId,
        string  $bomVersionId,
        ?string $versionItemId = null
    ): void
    {
        $items->each(
            callback: function (BomVersionItem $item)
            use ($bomVersionId, $woId, $versionItemId) {
                $dataInsert['woId'] = $woId;
                $dataInsert['bomVersionIds'] = $bomVersionId;
                $dataInsert['versionItemId'] = $versionItemId;
                $dataInsert['itemType'] = $item->itemType;
                $dataInsert['itemCode'] = $item->itemCode;
                $dataInsert['itemDescription'] = $item->itemDescription;
                $dataInsert['itemAddDescription'] = $item->itemAddDescription;
                $dataInsert['itemDrawingNumber'] = $item->itemDrawingNumber;
                $dataInsert['itemBomQty'] = $item->itemBomQty;
                $dataInsert['itemBomQtyConv'] = $item->itemBomQtyConv;
                $dataInsert['itemConvFactor'] = $item->itemConvFactor;
                $dataInsert['itemUom'] = $item->itemUom;
                $dataInsert['itemConvUom'] = $item->itemConvUom;
                $dataInsert['itemConvQty'] = $item->itemConvQty;
                $dataInsert['itemMaterialProcessType'] = $item->itemMaterialProcessType;
                $dataInsert['itemNote'] = $item->itemNote;
                $dataInsert['itemDetailDescription'] = $item->itemDetailDescription;
                $dataInsert['itemCurrentStock'] = $item->itemCurrentStock;
                $dataInsert['itemPositionNumber'] = $item->itemPositionNumber;
                $dataInsert['itemRevision'] = $item->itemDrawingRevision;
                $dataInsert['itemIssueAtProcess'] = $item->itemIssueAtProcess;
                $dataInsert['itemMake'] = $item->itemMake;
                $dataInsert['itemStore'] = $item->itemStore;
                $dataInsert['itemMaterialInput1'] = $item->itemMaterialInput1;
                $dataInsert['itemMaterialInput2'] = $item->itemMaterialInput2;
                $dataInsert['itemMaterialLenght'] = $item->itemMaterialLenght;
                $dataInsert['itemMaterialQty'] = $item->itemMaterialQty;
                $dataInsert['itemMaterialWeight'] = $item->itemMaterialWeight;
                $dataInsert['itemReqQty'] = $item->itemBomQty;
                $dataInsert['itemReqQtyConv'] = $item->itemBomQtyConv;
                $dataInsert['itemPendingQty'] = $item->itemBomQty;
                $dataInsert['itemPendingQtyConv'] = $item->itemBomQtyConv;
                $dataInsert['itemIssueQty'] = 0;
                $dataInsert['itemIssueQtyConv'] = 0;
                $dataInsert['itemLocation'] = null;
                $dataInsert['itemBinNumber'] = null;
                $dataInsert['bomItemCopy'] = null;
                $dataInsert['itemStatus'] = 'Pending';
                $dataInsert['itemAssemblyBomNumber'] = $item->itemAssemblyBomNumber;
                $response = WorkOrderItem::saveData($dataInsert);

                if ($response) {
                    if (count($item->children) > 0) {
                        $this->saveBomVersionItems(
                            items: $item->children,
                            woId: $woId,
                            bomVersionId: $bomVersionId,
                            versionItemId: $response->_id,
                        );
                    }
                }
            });
    }
}
