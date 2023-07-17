<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\Master\ProcessMaster;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class ProcessController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index()
    {
        $fetchData = ProcessMaster::all();

        $data['message'] = "Process Found";
        $data['status'] = 200;
        $data['data'] = $fetchData;
        return jsonData($data, Response::HTTP_OK);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request)
    {
        $party_master = ProcessMaster::saveData($request->all());

        $data['message'] = "Process Saved";
        $data['status'] = 200;
        $data['data'] = $party_master;
        return jsonData($data, Response::HTTP_OK);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function show($id)
    {
        $responce = ProcessMaster::getDataFromId($id);

        $data['message'] = "Machine found";
        $data['status'] = 200;
        $data['data'] = $responce;
        return new JsonResponse($data, Response::HTTP_OK);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(Request $request, $id)
    {
        $updateData = ProcessMaster::updateData($id, $request->all());

        $data['message'] = "Process Updated";
        $data['status'] = 200;
        $data['data'] = $updateData;
        return jsonData($data, Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function destroy($id)
    {
        ProcessMaster::destroyData($id);

        $data['message'] = "Process Master Deleted";
        $data['status'] = 200;
        $data['data'] = [];
        return jsonData($data, Response::HTTP_OK);
    }

    public function getProcessOptions()
    {
        $fetchData = ProcessMaster::all();

        foreach ($fetchData as $key => $value) {
            $response[$key]['label'] = $value->processName;
            $response[$key]['value'] = $value->_id;
        }

        $data['message'] = "Process Master Found";
        $data['status'] = 200;
        $data['data'] = $response ?? [];
        return jsonData($data, Response::HTTP_OK);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function checkProcessMasterExist(Request $request)
    {
        $data = $request->all();

        if(isset($data['id']) && !empty($data['id'])){

            $exists = ProcessMaster::checkExistsWithId($data['id'], ['processName' => $data['processName']]);

        }else{

            $exists = ProcessMaster::checkExists(['processName' => $data['processName']]);

        }

        $data['message'] = "Process Name check";
        $data['status'] = 200;
        $data['data'] = $exists;
        return jsonData($data);
    }
}
