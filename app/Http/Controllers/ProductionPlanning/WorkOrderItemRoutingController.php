<?php

namespace App\Http\Controllers\ProductionPlanning;

use App\Http\Controllers\Controller;
use App\Models\ProductionPlanning\WorkOrderItemRouting;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class WorkOrderItemRoutingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index()
    {
        $response = WorkOrderItemRouting::all();

        $data['status'] = 200;
        $data['message'] = 'Data Found';
        $data['data'] = $response;
        return jsonData($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @param WorkOrderItemRouting $workOrderItemRouting
     * @return JsonResponse
     */
    public function store(Request $request, WorkOrderItemRouting $workOrderItemRouting)
    {
        $dataInsert = $request->all();
        $response = $workOrderItemRouting->saveData($dataInsert);

        $data['status'] = 200;
        $data['message'] = 'Data Saved';
        $data['data'] = $response;
        return jsonData($data);
    }

    /**
     * Display the specified resource.
     *
     * @param WorkOrderItemRouting $workOrderItemRouting
     * @return JsonResponse
     */
    public function show(WorkOrderItemRouting $workOrderItemRouting)
    {
        $data['status'] = 200;
        $data['message'] = 'Data Found';
        $data['data'] = $workOrderItemRouting;
        return jsonData($data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param WorkOrderItemRouting $workOrderItemRouting
     * @return JsonResponse
     */
    public function update(Request $request, WorkOrderItemRouting $workOrderItemRouting)
    {
        $dataUpdate = $request->all();
        $response = $workOrderItemRouting->updateData($workOrderItemRouting->_id, $dataUpdate);

        $data['status'] = 200;
        $data['message'] = 'Data Updated';
        $data['data'] = $response;
        return jsonData($data);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param WorkOrderItemRouting $workOrderItemRouting
     * @return JsonResponse
     */
    public function destroy(WorkOrderItemRouting $workOrderItemRouting)
    {
        $workOrderItemRouting->delete();

        $data['status'] = 200;
        $data['message'] = 'Data Deleted';
        return jsonData($data);
    }

    /**
     * @param $woId
     * @param $itemId
     * @param WorkOrderItemRouting $workOrderItemRouting
     * @return JsonResponse
     */
    public function getWoItemRoutingList($woId, $itemId, WorkOrderItemRouting $workOrderItemRouting)
    {
        $response = $workOrderItemRouting->getData(['woId' => $woId, 'itemId' => $itemId]);

        $data['status'] = 200;
        $data['message'] = 'Data Found';
        $data['data'] = $response;
        return jsonData($data);
    }
}
