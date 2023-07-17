<?php

namespace App\Http\Controllers\Finance;

use App\Http\Controllers\Controller;
use App\Models\Finance\CostCenterMaster;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CostCenterMasterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index()
    {
        $fetchData = CostCenterMaster::all();

        $data['message'] = "Cost Center Master Found";
        $data['status'] = 200;
        $data['data'] = $fetchData;
        return new JsonResponse($data, Response::HTTP_OK);
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
        $dataInsert['groupCode'] = generateGroupCode($dataInsert, new CostCenterMaster);
        $party_master = CostCenterMaster::saveData($dataInsert);

        $data['message'] = "Chart Of Accounts Saved";
        $data['status'] = 200;
        $data['data'] = $party_master;
        return new JsonResponse($data, Response::HTTP_OK);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function show($id)
    {
        $response = CostCenterMaster::getDataFromId($id);

        $data['message'] = "Cost Center Master found";
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
        $dataUpdate = $request->all();
        unset($dataUpdate['d_id']);
        $updateData = CostCenterMaster::updateData($id, $dataUpdate);

        $data['message'] = "Chart Of Accounts Updated";
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
        CostCenterMaster::destroyData($id);

        $data['message'] = "Chart Of Accounts Master Deleted";
        $data['status'] = 200;
        $data['data'] = [];
        return jsonData($data, Response::HTTP_OK);
    }

    public function costCenterOptionsList()
    {
        $fetchData = CostCenterMaster::query()->where(['addedFrom' => auth()->id(), 'companyId' => 1])->whereNull('parentGroupId')->get();
        $response = createTree($fetchData, new CostCenterMaster());

        $data['message'] = "Chart Of Accounts Master Deleted";
        $data['status'] = 200;
        $data['data'] = $response;
        return jsonData($data, Response::HTTP_OK);
    }
}
