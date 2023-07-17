<?php

namespace App\Http\Controllers\ProductionPlanning;

use App\Http\Controllers\Controller;
use App\Models\Bom\BomVersionItem;
use App\Models\ProductionPlanning\WorkOrderItem;
use App\Models\ProductionPlanning\WorkOrderItemAssembly;
use App\Services\ProductionPlanning\WorkOrderService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class WorkOrderItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index()
    {
        $response = WorkOrderItem::all();

        $data['status'] = 200;
        $data['message'] = 'data found';
        $data['data'] = $response;
        return jsonData($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @param WorkOrderItem $workOrderItem
     * @param WorkOrderService $workOrderService
     * @return JsonResponse
     */
    public function store(Request $request, WorkOrderItem $workOrderItem, WorkOrderService $workOrderService): JsonResponse
    {
        $dataInsert = $request->all();
        $response = $workOrderItem->saveData($dataInsert);

        if ($dataInsert['assemblyCopy'] === 1) {
            $bomVersionItems = BomVersionItem::query()
                ->with('children')
                ->where('versionId', $dataInsert['assemblyFromVersionId'])
                ->whereNull('versionItemId')
                ->get();

            $workOrderService->saveBomVersionItems(
                items: $bomVersionItems,
                woId: $dataInsert['woId'],
                bomVersionId: $dataInsert['assemblyFromVersionId'],
                versionItemId: $response->_id
            );
        }

        $data['status'] = 200;
        $data['message'] = 'data saved';
        $data['data'] = $response;
        return jsonData($data);
    }

    /**
     * Display the specified resource.
     *
     * @param WorkOrderItem $workOrderItem
     * @return JsonResponse
     */
    public function show(WorkOrderItem $workOrderItem)
    {
        $data['status'] = 200;
        $data['message'] = 'data found';
        $data['data'] = $workOrderItem;
        return jsonData($data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param WorkOrderItem $workOrderItem
     * @return JsonResponse
     */
    public function update(Request $request, WorkOrderItem $workOrderItem)
    {
        $dataUpdate = $request->all();
        $response = $workOrderItem->updateData($workOrderItem->_id, $dataUpdate);

        $data['status'] = 200;
        $data['message'] = 'data updated';
        $data['data'] = $response;
        return jsonData($data);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param WorkOrderItem $workOrderItem
     * @return JsonResponse
     */
    public function destroy(WorkOrderItem $workOrderItem)
    {
        WorkOrderItem::deleteData(['versionItemId' => $workOrderItem->_id]);
        $workOrderItem->delete();
        WorkOrderItemAssembly::deleteData(['woItemId' => $workOrderItem->_id]);

        $data['status'] = 200;
        $data['message'] = 'data deleted';
        return jsonData($data);
    }

    /**
     * @param $woId
     * @param WorkOrderItem $workOrderItem
     * @return JsonResponse
     */
    public function getWorkOrderItems($woId, WorkOrderItem $workOrderItem): JsonResponse
    {
        $response = $workOrderItem->getData(['woId' => $woId, 'versionItemId' => null]);

        $data['status'] = 200;
        $data['message'] = 'data found';
        $data['data'] = $response;
        return jsonData($data);
    }

    public function getWorkOrderAssemblyItems($woId, $assemblyId, WorkOrderItem $workOrderItem): JsonResponse
    {
        $response = $workOrderItem->getData(['woId' => $woId, 'versionItemId' => $assemblyId]);

        $data['status'] = 200;
        $data['message'] = 'data found';
        $data['data'] = $response;
        return jsonData($data);
    }

    /**
     * @param WorkOrderItem $workOrderItem
     * @return JsonResponse
     */
    public function getWorkOrderItemList(WorkOrderItem $workOrderItem)
    {
        $response = $workOrderItem->getRelationData([],
            ['workOrderDetail' => function ($query) {
                $query->select('woNumber');
            }]);

        $data['status'] = 200;
        $data['message'] = 'data found';
        $data['data'] = $response;
        return jsonData($data);
    }

    /**
     * @param string $id
     * @return JsonResponse
     */
    public function getWorkOrderItemWithId(string $id): JsonResponse
    {
        $fetchData = WorkOrderItem::query()
            ->with(['workOrderDetail' => function ($query) {
                $query->select('_id', 'woNumber', 'woDate');
            }])
            ->select(['_id', 'woId', 'itemDescription', 'itemCode', 'itemReqQty'])
            ->where(['itemCode' => $id])
            ->get();

        foreach ($fetchData as $key => $value) {
            $response[$key]['label'] = '( ' . $value->workOrderDetail->woNumber . ' ) - ' . $value->itemDescription;
            $response[$key]['value'] = $value->_id;
        }

        $data['message'] = 'Data Found';
        $data['data'] = $response ?? [];
        return jsonData($data);
    }

    /**
     * @param string $id
     * @return JsonResponse
     */
    public function getWorkOrderItemForManualPlanning(string $id): JsonResponse
    {
        $response = WorkOrderItem::query()
            ->with(['workOrderDetail' => function ($query) {
                $query->select('_id', 'woNumber', 'woDate');
            }])
            ->select(['_id', 'woId', 'itemDescription', 'itemCode', 'itemReqQty'])
            ->find($id);

        $data['message'] = 'Data Found';
        $data['data'] = $response;
        return jsonData($data);
    }

    /**
     *
     * @return JsonResponse
     */
    public function getWorkOrderItemOptions(): JsonResponse
    {
        $fetchData = WorkOrderItem::getData(['itemType' => 'I']);

        foreach ($fetchData as $key => $value) {
            $response[$key]['label'] = $value->itemDetail->itemCode . ' - ' . $value->itemDescription;
            $response[$key]['value'] = $value->_id;
        }

        $data['message'] = 'Data Found';
        $data['data'] = $response ?? [];
        return jsonData($data);
    }

    public function getWorkOrderItemOption(): JsonResponse
    {
        $fetchData = WorkOrderItem::getData([]);
        foreach ($fetchData as $key => $value) {
            $response[$key]['label'] = $value->itemDetail->itemCode . ' - ' . $value->itemDescription;
            $response[$key]['value'] = $value->_id;
        }
        $data['message'] = 'Data Found';
        $data['data'] = $response ?? [];
        return jsonData($data);
    }

    /**
     *
     * @return JsonResponse
     */
    public function getWorkOrderAssemblyItemOptions(): JsonResponse
    {
        $fetchData = WorkOrderItem::getData(['itemType' => 'A']);

        foreach ($fetchData as $key => $value) {
            $response[$key]['label'] = $value->itemDetail->itemCode . ' - ' . $value->itemDescription;
            $response[$key]['value'] = $value->_id;
        }

        $data['message'] = 'Data Found';
        $data['data'] = $response ?? [];
        return jsonData($data);
    }

}
