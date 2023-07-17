<?php

namespace App\Http\Controllers\ProductionPlanning;

use App\Http\Controllers\Controller;
use App\Models\ProductionPlanning\WorkOrderNote;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class WorkOrderNoteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index()
    {
        $response = WorkOrderNote::all();

        $data['message'] = 'Data found';
        $data['data'] = $response;
        return jsonData($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @param WorkOrderNote $workOrderNote
     * @return JsonResponse
     */
    public function store(Request $request, WorkOrderNote $workOrderNote)
    {
        $dataInsert = $request->all();
        $response = $workOrderNote->saveData($dataInsert);

        $data['message'] = 'Data Saved';
        $data['data'] = $response;
        return jsonData($data);
    }

    /**
     * Display the specified resource.
     *
     * @param WorkOrderNote $workOrderNote
     * @return JsonResponse
     */
    public function show(WorkOrderNote $workOrderNote)
    {
        $data['message'] = 'Data Found';
        $data['data'] = $workOrderNote;
        return jsonData($data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param WorkOrderNote $workOrderNote
     * @return JsonResponse
     */
    public function update(Request $request, WorkOrderNote $workOrderNote)
    {
        $dataUpdate = $request->all();
        $response = $workOrderNote->updateData($workOrderNote->_id, $dataUpdate);

        $data['message'] = 'Data Updated';
        $data['data'] = $response;
        return jsonData($data);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param WorkOrderNote $workOrderNote
     * @return JsonResponse
     */
    public function destroy(WorkOrderNote $workOrderNote)
    {
        $workOrderNote->delete();

        $data['message'] = 'Data Deleted';
        $data['data'] = [];
        return jsonData($data);
    }

    /**
     * @param $id
     * @param WorkOrderNote $workOrderNote
     * @return JsonResponse
     */
    public function getWorkOrderNote($id, WorkOrderNote $workOrderNote)
    {
        $response = $workOrderNote->getData(['woId' => $id]);

        $data['message'] = 'Data found';
        $data['data'] = $response;
        return jsonData($data);
    }
}
