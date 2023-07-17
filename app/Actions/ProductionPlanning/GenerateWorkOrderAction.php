<?php

namespace App\Actions\ProductionPlanning;

use App\Models\ProductionPlanning\WorkOrder;
use App\Models\SalesCrm\SalesOrderItems;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Lorisleiva\Actions\Concerns\AsAction;

class GenerateWorkOrderAction
{
    use AsAction;

    public function handle(Request $request, WorkOrder $workOrder)
    {
        $dataInsert = $request->all();

        foreach ($dataInsert['itemIds'] as $key => $itemId) {
            try {
                unset($dataInsert['itemIds']);
                unset($dataInsert['partyName']);
                $dataInsert['woNumber'] = $this->generateWoNumber($workOrder);
                $dataInsert['woDate'] = date('Y-m-d');
                $dataInsert['itemId'] = $itemId;

                $itemDetails = SalesOrderItems::getFindRelationData($itemId, ['salesOrder' => function ($q) {
                    $q->select(['customerPoNo','salesOrderPoDate']);
                }]);
                $dataInsert['assemblyCode'] = $itemDetails->itemCode;
                $dataInsert['assembly'] = $itemDetails->itemName;
                $dataInsert['addDescription'] = $itemDetails->itemAddonDescription;
                $dataInsert['detailDescription'] = $itemDetails->itemDetailDescription;
                $dataInsert['drawingNo'] = $itemDetails->itemDrawingNo;
                $dataInsert['drawingRev'] = $itemDetails->itemDrawingRev;
                $dataInsert['woQty'] = $itemDetails->itemQuantity;
                $dataInsert['uom'] = $itemDetails->itemUom;
                $dataInsert['woStatus'] = 1;
                $dataInsert['woType'] = 1;
                $dataInsert['salesType'] = 1;
                $dataInsert['status'] = 1;
                $dataInsert['woStartDate'] = date('Y-m-d');
                $dataInsert['remark'] = $itemDetails->itemNote;
                $dataInsert['custPoNo'] = $itemDetails->salesOrder->customerPoNo;
                $dataInsert['poDate'] = $itemDetails->salesOrder->salesOrderPoDate;
                $dataInsert['LoginData']['createdBy'] = auth()->user()->first_name . ' ' . auth()->user()->last_name;
                $dataInsert['LoginData']['createdDate'] = date('d/m/Y H:i');
                $dataInsert['LoginData']['lastModifyBy'] = null;
                $dataInsert['LoginData']['lastModifyDate'] = null;
                $dataInsert['LoginData']['approveBy'] = null;
                $dataInsert['LoginData']['approveDate'] = null;

                $response = $workOrder->saveData($dataInsert);
            } catch (\Exception $e) {
                Log::error($e->getMessage());
            }
        }

        return $response ?? null;
    }

    public function generateWoNumber($workOrder)
    {
        $latest = $workOrder->query()->latest()->first();

        if (!$latest) {
            $newNumber = 'W00001';
        } else {
            $string = preg_replace("/[^0-9\.]/", '', $latest->woNumber);
            $newNumber = 'W' . sprintf('%05d', $string + 1);
        }

        return $newNumber;
    }
}
