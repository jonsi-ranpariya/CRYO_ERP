<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\Master\MachineMaster;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

use Illuminate\Http\Response;

class MachineController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index()
    {
        $fetchData = MachineMaster::all();

        $data['message'] = "Machine Found";
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
        $dataInsert = $request->all();
        $party_master = MachineMaster::saveData($dataInsert);

        $data['message'] = "Machine Saved";
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
        $response = MachineMaster::getDataFromId($id);

        $data['message'] = "Machine found";
        $data['status'] = 200;
        $data['data'] = $response;
        return jsonData($data, Response::HTTP_OK);
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
        $updateData = MachineMaster::updateData($id, $request->all());

        $data['message'] = "Machine Updated";
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
        MachineMaster::destroyData($id);

        $data['message'] = "Note Master Deleted";
        $data['status'] = 200;
        $data['data'] = [];
        return jsonData($data, Response::HTTP_OK);
    }

    public function getMachineOptions()
    {
        $fetchData = MachineMaster::all();

        foreach ($fetchData as $key => $value) {
            $response[$key]['label'] = $value->machineName;
            $response[$key]['value'] = $value->_id;
        }

        $data['message'] = "Machine Master Found";
        $data['status'] = 200;
        $data['data'] = $response ?? [];
        return jsonData($data, Response::HTTP_OK);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function checkMachineMasterExist(Request $request)
    {
        $data = $request->all();

        if(isset($data['id']) && !empty($data['id'])){

            $exists = MachineMaster::checkExistsWithId($data['id'], ['machineName' => $data['machineName']]);

        }else{

            $exists = MachineMaster::checkExists(['machineName' => $data['machineName']]);

        }

        $data['message'] = "Machine check";
        $data['status'] = 200;
        $data['data'] = $exists;
        return jsonData($data);
    }
}
