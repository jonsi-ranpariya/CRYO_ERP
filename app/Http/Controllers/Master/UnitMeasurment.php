<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;use App\Models\Master\PackingMaster;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Models\Master\UnitMeasurment as UnitModel;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class UnitMeasurment extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index()
    {
        $fetchData = UnitModel::all();

        $data['message'] = "UOM Found";
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
        $party_master = UnitModel::saveData($dataInsert);

        $data['message'] = "UOM Saved";
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
        $responce = UnitModel::getDataFromId($id);

        $data['message'] = "UOM found";
        $data['status'] = 200;
        $data['data'] = $responce;
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
        $updateData = UnitModel::updateData($id, $request->all());

        $data['message'] = "UOM Updated";
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
        UnitModel::destroyData($id);

        $data['message'] = "UOM Deleted";
        $data['status'] = 200;
        $data['data'] = [];
        return jsonData($data, Response::HTTP_OK);
    }

    /**
     * @return JsonResponse
     */
    public function getUomOptions()
    {
        $fetchData = UnitModel::getData();
        foreach ($fetchData as $key => $value) {
            $fetchData[$key]['label'] = $value->uom;
            $fetchData[$key]['value'] = $value->_id;
        }
        $data['message'] = "UOM Options List";
        $data['status'] = 200;
        $data['data'] = $fetchData;
        return jsonData($data, Response::HTTP_OK);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function checkUomExist(Request $request)
    {
        $data = $request->all();

        if(isset($data['id']) && !empty($data['id'])){

            $exists = UnitModel::checkExistsWithId($data['id'], ['uom' => $data['uom']]);

        }else{

            $exists = UnitModel::checkExists(['uom' => $data['uom']]);

        }


        $data['message'] = "UOM Check";
        $data['status'] = 200;
        $data['data'] = $exists;
        return jsonData($data);
    }

}
