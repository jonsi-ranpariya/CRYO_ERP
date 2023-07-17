<?php

namespace App\Http\Controllers\ProductionPlanning;

use App\Http\Controllers\Controller;
use App\Models\ProductionPlanning\ProcessSheetList;
use App\Models\ProductionPlanning\ProcessSheetMaster;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProcessSheetMasterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index()
    {
        $response = ProcessSheetMaster::all();

        $data['message'] = 'Data Found';
        $data['data'] = $response;
        return jsonData($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param ProcessSheetMaster $processSheetMaster
     * @return JsonResponse
     */
    public function store(Request $request, ProcessSheetMaster $processSheetMaster)
    {
        $dataInsert = $request->all();
        $dataInsert['processSheetNo'] = generateCodes(new ProcessSheetMaster(),'00001', 'processSheetNo');
        $response = $processSheetMaster->saveData($dataInsert);

        $data['message'] = 'Data saved';
        $data['status'] = 200;
        $data['data'] = $response;
        return jsonData($data);
    }

    /**
     * Display the specified resource.
     *
     * @param  ProcessSheetMaster  $processSheetMaster
     * @return JsonResponse
     */
    public function show(ProcessSheetMaster $processSheetMaster)
    {
        $data['message'] = 'Data Found';
        $data['status'] = 200;
        $data['data'] = $processSheetMaster;
        return jsonData($data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ProductionPlanning\ProcessSheetMaster  $processSheetMaster
     * @return JsonResponse
     */
    public function update(Request $request, ProcessSheetMaster $processSheetMaster)
    {
        $dataUpdate = $request->all();
        $response = $processSheetMaster->updateData($processSheetMaster->_id, $dataUpdate);

        $data['message'] = 'Data Updated';
        $data['status'] = 200;
        $data['data'] = $response;
        return jsonData($data);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ProductionPlanning\ProcessSheetMaster  $processSheetMaster
     * @return JsonResponse
     */
    public function destroy($id)
    {
        ProcessSheetMaster::destroy($id);
        ProcessSheetList::deleteData(['processSheetId' => $id]);

        $data['message'] = 'Data Deleted';
        $data['status'] = 200;
        $data['data'] = [];
        return jsonData($data);
    }

    /**
     * @param string $itemId
     * @return JsonResponse
     */
    public function getProcessNumberByItemId(string $itemId)
    {
        $processSheetNo = ProcessSheetMaster::query()
            ->where('itemId', $itemId)
            ->first()
            ?->processSheetNo ?? null;

        $data['message'] = 'Data Found';
        $data['data'] = $processSheetNo;
        return jsonData($data);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function checkProcessSheetItemCodeExist(Request $request)
    {
        $data = $request->all();

        if(isset($data['id']) && !empty($data['id'])){

            $exists = ProcessSheetMaster::checkExistsWithId($data['id'], ['itemCode' => $data['itemCode']]);
        }else{
            $exists = ProcessSheetMaster::checkExists(['itemCode' => $data['itemCode']]);
        }

        $data['message'] = "Process Sheet Item Code check";
        $data['status'] = 200;
        $data['data'] = $exists;
        return jsonData($data);
    }
}
