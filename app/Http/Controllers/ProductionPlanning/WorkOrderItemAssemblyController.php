<?php

namespace App\Http\Controllers\ProductionPlanning;

use App\Http\Controllers\Controller;
use App\Models\ProductionPlanning\WorkOrderItemAssembly;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class WorkOrderItemAssemblyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index()
    {
        $response = WorkOrderItemAssembly::all();

        $data['status'] = 200;
        $data['message'] = 'Data Found';
        $data['data'] = $response;
        return jsonData($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @param WorkOrderItemAssembly $workOrderItemAssembly
     * @return JsonResponse
     */
    public function store(Request $request, WorkOrderItemAssembly $workOrderItemAssembly)
    {
        $dataInsert = $request->all();
        $response = $workOrderItemAssembly->saveData($dataInsert);

        $data['status'] = 200;
        $data['message'] = 'Data Saved';
        $data['data'] = $response;
        return jsonData($data);
    }

    /**
     * Display the specified resource.
     *
     * @param WorkOrderItemAssembly $workOrderItemAssembly
     * @return JsonResponse
     */
    public function show(WorkOrderItemAssembly $workOrderItemAssembly)
    {
        $data['status'] = 200;
        $data['message'] = 'Data Found';
        $data['data'] = $workOrderItemAssembly;
        return jsonData($data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param WorkOrderItemAssembly $workOrderItemAssembly
     * @return JsonResponse
     */
    public function update(Request $request, WorkOrderItemAssembly $workOrderItemAssembly)
    {
        $dataUpdate = $request->all();
        $response = $workOrderItemAssembly->updateData($workOrderItemAssembly->_id, $dataUpdate);

        $data['status'] = 200;
        $data['message'] = 'Data Updated';
        $data['data'] = $response;
        return jsonData($data);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param WorkOrderItemAssembly $workOrderItemAssembly
     * @return JsonResponse
     */
    public function destroy(WorkOrderItemAssembly $workOrderItemAssembly)
    {
        $workOrderItemAssembly->delete();

        $data['status'] = 200;
        $data['message'] = 'Data Deleted';
        return jsonData($data);
    }

    /**
     * @param $orderId
     * @param $itemId
     * @param WorkOrderItemAssembly $workOrderItemAssembly
     * @return JsonResponse
     */
    public function getWorkOrderItemAssemblyList($orderId, $itemId, WorkOrderItemAssembly $workOrderItemAssembly)
    {
        $response = $workOrderItemAssembly->getData(['woId' => $orderId,'woItemId' => $itemId]);

        $data['status'] = 200;
        $data['message'] = 'Data found';
        $data['data'] = $response;
        return jsonData($data);
    }
}
