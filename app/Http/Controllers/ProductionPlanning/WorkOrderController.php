<?php

namespace App\Http\Controllers\ProductionPlanning;

use App\Actions\ProductionPlanning\GenerateWorkOrderAction;
use App\Actions\ProductionPlanning\WorkOrderSearchAction;
use App\Enums\Inventory\TransactionTypeEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\ProductionPlanning\WorkOrderItemMaterialIssueRequest;
use App\Models\ProductionPlanning\WorkOrder;
use App\Models\ProductionPlanning\WorkOrderItem;
use App\Models\ProductionPlanning\WorkOrderItemAssembly;
use App\Models\ProductionPlanning\WorkOrderItemRouting;
use App\Models\ProductionPlanning\WorkOrderNote;
use App\Models\ProductionPlanning\WorkOrderRouting;
use App\Services\Inventory\StockLedgerService;
use App\Services\ProductionPlanning\WorkOrderService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class WorkOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $response = WorkOrder::all();

        $data['message'] = 'Data Found';
        $data['data'] = $response;
        return jsonData($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @param WorkOrderService $workOrderService
     * @return JsonResponse
     */
    public function store(Request $request, WorkOrderService $workOrderService): JsonResponse
    {
        $dataInsert = $request->all();
        $dataInsert['woNumber'] = generateCodes(new WorkOrder(), 'W00001', 'woNumber', 'W');
        $response = $workOrderService->saveWorkOrderWithBomItems($dataInsert);

        $data['message'] = 'Data saved';
        $data['data'] = $response;
        return jsonData($data);
    }

    /**
     * Display the specified resource.
     *
     * @param WorkOrder $workOrder
     * @return JsonResponse
     */
    public function show(WorkOrder $workOrder): JsonResponse
    {
        $data['message'] = 'Data Found';
        $data['data'] = $workOrder;
        return jsonData($data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param WorkOrder $workOrder
     * @return JsonResponse
     */
    public function update(Request $request, WorkOrder $workOrder): JsonResponse
    {
        $dataUpdate = $request->all();
        $response = $workOrder->updateData($workOrder->_id, $dataUpdate);

        $data['message'] = 'Data Updated';
        $data['data'] = $response;
        return jsonData($data);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param WorkOrder $workOrder
     * @return JsonResponse
     */
    public function destroy(WorkOrder $workOrder): JsonResponse
    {
        $workOrder->delete();
        try {
            WorkOrderNote::deleteData(['woId' => $workOrder->_id]);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
        }

        try {
            WorkOrderItem::deleteData(['woId' => $workOrder->_id]);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
        }

        try {
            WorkOrderItemAssembly::deleteData(['woId' => $workOrder->_id]);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
        }

        try {
            WorkOrderRouting::deleteData(['woId' => $workOrder->_id]);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
        }

        try {
            WorkOrderItemRouting::deleteData(['woId' => $workOrder->_id]);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
        }

        $data['message'] = 'Data Deleted';
        $data['data'] = [];
        return jsonData($data);
    }

    /**
     * @param WorkOrder $workOrder
     * @return JsonResponse
     */
    public function getPendingOrders(WorkOrder $workOrder): JsonResponse
    {
        $response = $workOrder->getData(['status' => 1]);

        $data['message'] = 'Data Found';
        $data['data'] = $response;
        return jsonData($data);
    }

    /**
     * @param $id
     * @return JsonResponse
     */
    public function getPendingWorkOrderWithAssemblyItem($id): JsonResponse
    {
        $response = WorkOrderItem::getData(['woId' => $id, 'versionItemId' => null]);

        $data['message'] = 'Data Found';
        $data['data'] = $response;
        return jsonData($data);
    }

    public function getPendingWorkOrderWithAssemblyItemChild($id): JsonResponse
    {
        $response = WorkOrderItem::getData(['versionItemId' => $id]);

        $data['message'] = 'Data Found';
        $data['data'] = $response;
        return jsonData($data);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function getWorkOrderItemFromIds(Request $request): JsonResponse
    {
        $response = WorkOrderItem::whereInData('_id', $request->ids);

        $data['message'] = 'Data Found';
        $data['data'] = $response;
        return jsonData($data);
    }

    /**
     * @param Request $request
     * @param WorkOrder $workOrder
     * @param GenerateWorkOrderAction $workOrderAction
     * @return JsonResponse
     */
    public function generateWoFromSo(Request $request, WorkOrder $workOrder, GenerateWorkOrderAction $workOrderAction): JsonResponse
    {
        $response = $workOrderAction->handle($request, $workOrder);

        $data['message'] = 'Data saved';
        $data['data'] = $response ?? null;
        return jsonData($data);
    }

    /**
     * @param WorkOrder $workOrder
     * @return JsonResponse
     */
    public function getWorkOrderOptions(WorkOrder $workOrder): JsonResponse
    {
        $items = $workOrder->all();
        $response = $items->map(fn (WorkOrder $item) => [
            'label' => $item->woNumber . " (" . $item->assemblyCode . ")",
            'value' => $item->_id
        ]);

        $data['message'] = $response->isNotEmpty() ? 'Data Found' : 'No Data Available';
        $data['data'] = $response;
        return jsonData($data);
    }

    /**
     * @param string $id
     * @return JsonResponse
     */
    public function getWorkOrderFromItemOption(string $id): JsonResponse
    {
        $fetchData = WorkOrder::getData(['itemId' => $id]);

        foreach ($fetchData as $key => $value) {
            $response[$key]['label'] = $value->woNumber . " (" . $value->assemblyCode . ")";
            $response[$key]['value'] = $value->_id;
        }

        $data['message'] = 'Data Found';
        $data['data'] = $response ?? [];
        return jsonData($data);
    }

    /**
     * @param Request $request
     * @param WorkOrderSearchAction $workOrderSearchAction
     * @return JsonResponse
     */
    public function getWorkOrderListWithParty(Request $request, WorkOrderSearchAction $workOrderSearchAction): JsonResponse
    {
        $response = $workOrderSearchAction->handle($request);

        $data['message'] = 'Data Found';
        $data['data'] = $response;
        return jsonData($data);
    }

    /**
     * @param $id
     * @param WorkOrderItem $workOrderItem
     * @return JsonResponse
     */
    public function getAllWorkOrderWithAssemblyItem($id, WorkOrderItem $workOrderItem): JsonResponse
    {
        $response = $workOrderItem->query()
            ->select(['_id', 'woId', 'itemCode', 'itemDescription', 'itemDetailDescription', 'itemDrawingNumber', 'itemUom'])
            ->where('woId', $id)
            ->whereNull('versionItemId')
            ->get();

        if ($response->isNotEmpty()) {
            $response->each(function (WorkOrderItem $item) {
                $item->setAppends(['item_name', 'uom_detail']);
                return $item;
            });
        }

        $data['message'] = 'Data Found';
        $data['data'] = $response;
        return jsonData($data);
    }

    /**
     * @param $id
     * @param WorkOrderItemAssembly $workOrderItemAssembly
     * @return JsonResponse
     */
    public function getWorkOrderWithAssemblyItem($id, WorkOrderItemAssembly $workOrderItemAssembly): JsonResponse
    {
        $response = $workOrderItemAssembly->getRelationData(
            ['woId' => $id, 'itemType' => 'A'],
            ['workOrderDetails' => function ($query) {
                $query->select(['woNumber', 'assembly', 'assemblyCode']);
            }]
        );

        $data['message'] = 'Data Found';
        $data['data'] = $response;
        return jsonData($data);
    }

    /**
     * @param Request $request
     * @param WorkOrder $workOrder
     * @return JsonResponse
     */
    public function getWrkOrderFilter(Request $request, WorkOrder $workOrder): JsonResponse
    {
        $woNumber = $request->woNumber;
        $itemCode = $request->assemblyCode;
        $itemDescription = $request->assembly;
        $drawingNumber = $request->drawingNo;

        $itemDetails = $workOrder->query();

        if (!empty($woNumber)) {
            $itemDetails->where('woNumber', 'LIKE', "%{$woNumber}%");
        }

        if (!empty($itemCode)) {
            $itemDetails->where('assemblyCode', 'LIKE', "%{$itemCode}%");
        }

        if (!empty($itemDescription)) {
            $itemDetails->where('assembly', 'LIKE', "%{$itemDescription}%");
        }

        if (!empty($drawingNumber)) {
            $itemDetails->where('drawingNo', 'LIKE', "%{$drawingNumber}%");
        }

        if (empty($woNumber) && empty($itemCode) && empty($itemDescription) && empty($drawingNumber)) {
            $response = [];
        } else {
            $response = $itemDetails->get();
        }

        $data['message'] = "Item Work Order List";
        $data['status'] = 200;
        $data['data'] = $response;
        return jsonData($data);
    }

    /**
     * @param WorkOrderItemMaterialIssueRequest $request
     * @param StockLedgerService $service
     * @return array|JsonResponse
     */
    public function materialIssueWorkOrderItem(
        WorkOrderItemMaterialIssueRequest $request,
        StockLedgerService $service
    ): array|JsonResponse
    {
        $workOrderId = $request->workOrderId;
        $workOrderItemId = $request->workOrderItemId;
        $issueQty = $request->canIssueQty;

        $workOrderItem = WorkOrderItem::find($workOrderItemId);

        $transaction = $service->transactionStoreService(dataInsert: [
            "cFactor" => $workOrderItem->itemConvFactor,
            "conversionQty" => $workOrderItem->itemConvQty,
            "conversionUom" => $workOrderItem->itemConvUom,
            "currentStock" => $workOrderItem->itemCurrentStock,
            "documentDate" => $workOrderItem->wo_details->woDate,
            "documentNo" => $workOrderItem->wo_details->woNumber,
            "issueByPerson" => auth()->user()->first_name . ' ' . auth()->user()->last_name,
            "itemAddDescription" => $workOrderItem->itemAddDescription,
            "itemCode" => $workOrderItem->item_name->itemCode,
            "itemDescription" => $workOrderItem->itemDescription,
            "itemDetailDescription" => $workOrderItem->itemDetailDescription,
            "itemDrawingNo" => $workOrderItem->itemDrawingNumber,
            "itemId" => $workOrderItem->itemCode,
            "itemMake" => $workOrderItem->itemMake,
            "itemRev" => $workOrderItem->itemRevision,
            "itemUom" => $workOrderItem->itemUom,
            "leadTime" => null,
            "minimumStock" => null,
            "openingStock" => null,
            "party" => getPartyNameFromPartyCode(partyCode: $workOrderItem->wo_details?->partyCode ?? null),
            "rate" => null,
            "receivedByPerson" => auth()->user()->first_name . ' ' . auth()->user()->last_name,
            "reference" => null,
            "rejectedQty" => 0,
            "remark" => null,
            "transaction" => 3,
            "transactionQty" => (float)$issueQty,
            "transactionType" => TransactionTypeEnum::Issue,
            "value" => null,
            "woPoNo" => null
        ]);

        if ($transaction) {
            $workOrderItem->itemIssueQty = $workOrderItem->itemIssueQty + $issueQty;
            $workOrderItem->itemPendingQty = $workOrderItem->itemPendingQty - $issueQty;
            if ($workOrderItem->itemPendingQty == 0) {
                $workOrderItem->itemStatus = 'Completed';
            } else {
                $workOrderItem->itemStatus = 'Pending';
            }
            $workOrderItem->update();

            return [
                'message' => 'Material Issue Successfully.'
            ];
        }

        return response()->json([
            'message' => 'No Item QTY available.'
        ],400);
    }
}
