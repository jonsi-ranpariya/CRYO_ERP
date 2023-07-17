<?php

namespace App\Http\Controllers\ProductionPlanning;

use App\Http\Controllers\Controller;
use App\Models\ProductionPlanning\ProcessSheetList;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProcessSheetListController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index()
    {
        $response = ProcessSheetList::all();

        $data['message'] = 'Process SheetList Found';
        $data['data'] = $response;
        return jsonData($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @param ProcessSheetList $processSheetList
     * @return JsonResponse
     */
    public function store(Request $request, ProcessSheetList $processSheetList): JsonResponse
    {
        $dataInsert = $request->all();
        $response = $processSheetList->saveData($dataInsert);
        $data['message'] = 'process Sheet List saved';
        $data['status'] = 200;
        $data['data'] = $response;
        return jsonData($data);
    }

    /**
     * Display the specified resource.
     *
     * @param ProcessSheetList $processSheetList
     * @return JsonResponse
     */
    public function show(ProcessSheetList $processSheetList): JsonResponse
    {
        $data['message'] = 'process details Data Found';
        $data['status'] = 200;
        $data['data'] = $processSheetList;
        return jsonData($data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param ProcessSheetList $processSheetList
     * @return JsonResponse
     */
    public function update(Request $request, ProcessSheetList $processSheetList): JsonResponse
    {
        $dataUpdate = $request->all();
        $response = $processSheetList->updateData($processSheetList->_id, $dataUpdate);

        $data['message'] = 'process details Data Updated';
        $data['status'] = 200;
        $data['data'] = $response;
        return jsonData($data);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param ProcessSheetList $processSheetList
     * @return JsonResponse
     */
    public function destroy(ProcessSheetList $processSheetList): JsonResponse
    {
        $processSheetList->delete();

        $data['message'] = 'process details Data Deleted';
        $data['status'] = 200;
        $data['data'] = [];
        return jsonData($data);
    }

    /**
     * @param $id
     * @return JsonResponse
     */
    public function getProcessSheetList($id): JsonResponse
    {
        $partyData = ProcessSheetList::getData(['processSheetId' => $id]);
        $data['message'] = "Data Found";
        $data['status'] = 200;
        $data['data'] = $partyData;
        return jsonData($data);
    }

    public function getProcessSheetListOption(): JsonResponse
    {
        $items = ProcessSheetList::all();
        if ($items->isNotEmpty()) {
            $response = $items->map(function (ProcessSheetList $item) {
                return [
                    'label' => $item->processId,
                    'value' => $item->_id
                ];
            });
        }

        $data['message'] = "Process Master Found";
        $data['status'] = 200;
        $data['data'] = $response ?? [];
        return jsonData($data);
    }

    public function getProcessSheetListOptions(): JsonResponse
    {
        $items = ProcessSheetList::all();

        if ($items->isNotEmpty()) {
            $response = $items->map(function (ProcessSheetList $item) {
                return [
                    'label' => $item->processDesc,
                    'value' => $item->_id,
                ];
            });
        }

        $data['message'] = 'Data Found';
        $data['data'] = $response ?? [];
        $data['status'] = 200;
        return jsonData($data);
    }
}
