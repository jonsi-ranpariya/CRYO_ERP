<?php

namespace App\Http\Controllers\ProductionPlanning;

use App\Http\Controllers\Controller;
use App\Models\ProductionPlanning\WorkOrderRouting;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class WorkOrderRoutingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index()
    {
        $response = WorkOrderRouting::all();

        $data['status'] = 200;
        $data['message'] = 'Data Found';
        $data['data'] = $response;
        return jsonData($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @param  WorkOrderRouting  $workOrderRouting
     * @return JsonResponse
     */
    public function store(Request $request, WorkOrderRouting $workOrderRouting)
    {
        $dataInsert = $request->all();
        $response = $workOrderRouting->saveData($dataInsert);

        $data['status'] = 200;
        $data['message'] = 'Data Saved';
        $data['data'] = $response;
        return jsonData($data);
    }

    /**
     * Display the specified resource.
     *
     * @param  WorkOrderRouting  $workOrderRouting
     * @return JsonResponse
     */
    public function show(WorkOrderRouting $workOrderRouting)
    {
        $data['status'] = 200;
        $data['message'] = 'Data Found';
        $data['data'] = $workOrderRouting;
        return jsonData($data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  WorkOrderRouting  $workOrderRouting
     * @return JsonResponse
     */
    public function update(Request $request, WorkOrderRouting $workOrderRouting)
    {
        $dataUpdate = $request->all();
        $response = $workOrderRouting->updateData($workOrderRouting->_id,$dataUpdate);

        $data['status'] = 200;
        $data['message'] = 'Data Updated';
        $data['data'] = $response;
        return jsonData($data);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  WorkOrderRouting  $workOrderRouting
     * @return JsonResponse
     */
    public function destroy(WorkOrderRouting $workOrderRouting)
    {
        $workOrderRouting->delete();

        $data['status'] = 200;
        $data['message'] = 'Data Deleted';
        return jsonData($data);
    }

    /**
     * @param $id
     * @param WorkOrderRouting $workOrderRouting
     * @return JsonResponse
     */
    public function getWorkOrderRouting($id, WorkOrderRouting $workOrderRouting)
    {
        $response = $workOrderRouting->getData(['woId' => $id]);

        $data['status'] = 200;
        $data['message'] = 'Data Found';
        $data['data'] = $response;
        return jsonData($data);
    }
}
