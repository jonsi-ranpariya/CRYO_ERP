<?php

namespace App\Http\Controllers\QualityControl;

use App\Http\Controllers\Controller;
use App\Models\QualityControl\WorkOrderSubAssemblyQc;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class WorkOrderSubAssemblyQcController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index() : JsonResponse
    {
        $response = WorkOrderSubAssemblyQc::all();

        $data['message'] = 'Data Found';
        $data['status'] = 200;
        $data['data'] = $response;
        return jsonData($data);

    }

    /**
     * Store a newly created resource in storage.
     * @param WorkOrderSubAssemblyQc $workOrderSubAssemblyQc
     * @param Request  $request
     * @return JsonResponse
     */
    public function store(Request $request, WorkOrderSubAssemblyQc $workOrderSubAssemblyQc) : JsonResponse
    {
        $dataInsert = $request->all();
        $response = $workOrderSubAssemblyQc->saveData($dataInsert);

        $data['message'] = 'Data Saved';
        $data['status'] = 200;
        $data['data'] = $response;
        return jsonData($data);
    }

    /**
     * Display the specified resource.
     *
     * @param  WorkOrderSubAssemblyQc  $workOrderSubAssemblyQc
     * @return JsonResponse
     */
    public function show(WorkOrderSubAssemblyQc $workOrderSubAssemblyQc): JsonResponse
    {
        $data['message'] = 'Data Found';
        $data['status'] = 200;
        $data['data'] = $workOrderSubAssemblyQc;
        return jsonData($data);
    }
    /**
     * Update the specified resource in storage.
     *
     * @param Request  $request
     * @param  WorkOrderSubAssemblyQc  $workOrderSubAssemblyQc
     * @return JsonResponse
     */
    public function update(Request $request, WorkOrderSubAssemblyQc $workOrderSubAssemblyQc): JsonResponse
    {
        $dataUpdate = $request->all();
        $response = $workOrderSubAssemblyQc->updateData($dataUpdate['_id'], $dataUpdate);

        $data['message'] = 'Data Updated';
        $data['status'] = 200;
        $data['data'] = $response;
        return jsonData($data);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param WorkOrderSubAssemblyQc  $workOrderSubAssemblyQc
     * @return JsonResponse
     */
    public function destroy(string $id): JsonResponse
    {
        WorkOrderSubAssemblyQc::destroyData($id);

        $data['message'] = 'Data Deleted';
        $data['status'] = 200;
        return jsonData($data);
    }
}
